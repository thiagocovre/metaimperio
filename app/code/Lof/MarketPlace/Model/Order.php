<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Model;

use Lof\MarketPlace\Helper\SellerOrderHelper;
use Lof\MarketPlace\Model\Orderitems;
use Magento\Authorization\Model\CompositeUserContext;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Registry;
use Magento\Sales\Model\Order as BaseOrder;
use Magento\TestFramework\Exception\NoSuchActionException;

/**
 * Orderitems Model
 */
class Order extends \Magento\Framework\Model\AbstractModel implements \Lof\MarketPlace\Api\SalesRepositoryInterface
{
    protected $helper;
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;
    protected $userContext;
    protected $sellerFactory;
    protected $orderFactory;
    /**
     * @var \Lof\MarketPlace\Model\Orderitems
     */
    private $orderItem;
    /**
     * @var \Lof\MarketPlace\Helper\Seller
     */
    private $helperSeller;

    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        Context $context,
        Registry $registry,
        CompositeUserContext $userContext,
        Orderitems $orderitems,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        SellerOrderHelper $helper,
        \Lof\MarketPlace\Helper\Seller $helperSeller,
        SellerFactory $sellerFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory
    ){
        $this->helper = $helper;
        $this->orderItem = $orderitems;
        $this->priceCurrency = $priceCurrency;
        $this->sellerFactory = $sellerFactory;
        $this->orderFactory = $orderFactory;
        $this->userContext = $userContext;
        $this->helperSeller = $helperSeller;
        parent::__construct($context,$registry,$resource,$resourceCollection);
    }

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Lof\MarketPlace\Model\ResourceModel\Order');
    }

    /**
     * Get order object
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        $order = $this->orderFactory->create()->load($this->getOrderId(), 'entity_id');
        return $order;
    }


    /**
     * @return \Magento\Sales\Model\Order\Item[]
     */
    public function getAllItems()
    {
        if ($this->getData('all_items') == null) {
            $items = [];
            foreach ($this->getOrder()->getAllItems() as $item) {
                if ($item->getOrderId() == $this->getOrderId()) {
                    $items[$item->getId()] = $item;
                }
            }
            $this->setData('all_items',$items);
        }
        return $this->getData('all_items');
    }

    /**
     * Retrieve order invoice availability
     *
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function canInvoice()
    {
        $order = $this->getOrder();

        if ($this->canUnhold() || $order->isPaymentReview()) {
            return false;
        }

        $status = $this->getStatus();

        if ($this->isCanceled() || $status === BaseOrder::STATE_COMPLETE || $status === BaseOrder::STATE_CLOSED) {
            return false;
        }
        $sellerId = $this->helperSeller->getSellerId();
        $orderItems = $this->orderItem->getCollection()->addFieldToFilter('seller_id', $sellerId)->addFieldToFilter('order_id',$this->getOrderId());
        foreach ($this->getAllItems() as $item) {
            foreach ($orderItems as $orderItem) {
                if ($item->getItemId() == $orderItem->getOrderItemId() && $item->getQtyToInvoice() > 0 && !$item->getLockedDoInvoice()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Check whether order is canceled
     *
     * @return bool
     */
    public function isCanceled()
    {
        return $this->getStatus() === BaseOrder::STATE_CANCELED;
    }
    /**
     * Retrieve order unhold availability
     *
     * @return bool
     */
    public function canUnhold()
    {
        if ($this->getOrder()->isPaymentReview()) {
            return false;
        }
        return $this->getStatus() === BaseOrder::STATE_HOLDED;
    }
    public function canCancel()
    {
        if ($this->canUnhold()) {
            return false;
        }
        $allInvoiced = true;
        foreach ($this->getAllItems() as $item) {
            if ($item->getQtyToInvoice()) {
                $allInvoiced = false;
                break;
            }
        }
        if ($allInvoiced) {
            return false;
        }
        $state = $this->getStatus();
        if ($this->isCanceled() || $state === BaseOrder::STATE_COMPLETE || $state === BaseOrder::STATE_CLOSED) {
            return false;
        }
        return true;
    }
    /**
     * Retrieve order shipment availability
     *
     * @return bool
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function canShip()
    {
        $order = $this->getOrder();

        if ($this->canUnhold() || $order->isPaymentReview()) {
            return false;
        }

        if ($order->getIsVirtual() || $order->isCanceled()) {
            return false;
        }
        $sellerId = $this->helperSeller->getSellerId();
        $orderItems = $this->orderItem->getCollection()->addFieldToFilter('seller_id', $sellerId)->addFieldToFilter('order_id',$this->getOrderId());
        foreach ($this->getAllItems() as $item) {
            foreach ($orderItems as $orderItem) {
                if ($item->getItemId() == $orderItem->getOrderItemId() && $item->getQtyToShip() > 0 && !$item->getIsVirtual() && !$item->getLockedDoShip()) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Retrieve order credit memo (refund) availability
     *
     * @return bool
     */
    public function canCreditmemo()
    {
        if ($this->hasForcedCanCreditmemo()) {
            return $this->getForcedCanCreditmemo();
        }

        if ($this->canUnhold() || $this->getOrder()->isPaymentReview()) {
            return false;
        }

        if ($this->isCanceled() || $this->getState() === BaseOrder::STATE_CLOSED) {
            return false;
        }

        /**
         * We can have problem with float in php (on some server $a=762.73;$b=762.73; $a-$b!=0)
         * for this we have additional diapason for 0
         * TotalPaid - contains amount, that were not rounded.
         */
        if (abs($this->priceCurrency->round($this->getTotalPaid()) - $this->getTotalRefunded()) < .0001) {
            return false;
        }

        return true;
    }

    /**
     * GET seller order
     * @param int $customerId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getSellerOrders($customerId)
    {
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        $sellerId = $seller->getData()[0]['seller_id'];
        if ($sellerId) {
            $res = [
                "code" => 405,
                "message" => "Get data failed"
            ];
            $data = $this->getCollection()->addFieldToFilter('seller_id', $sellerId)->getData();
            if ($data) {
                $res["code"] = 0;
                $res["message"] = "get data success!";
                $res["result"]["order"][] = $data;
            } else {
                $res["code"] = 0;
                $res["message"] = "get data success!";
                $res["result"]["order"] = [];
            }
        } else {
            throw new NoSuchEntityException(__('Customer has not register seller yet.'));
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     * @throws NoSuchActionException
     */
    public function getSellerOrderById($OrderId, $customerId)
    {
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter("customer_id", $customerId);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $res = ["code" => 405, "message" => "Get data failed"];
        $order_data[] = $this->load($OrderId)->getData();
        if (count($seller->getData())>0) {
            $seller_id = $seller->getData()[0]['seller_id'];
        } else {
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        if ($order_data) {
            try {
                $order = $objectManager->create('Magento\Sales\Model\Order')->loadByIncrementId($order_data[0]["increment_id"]);
                $orderItems = $order->getAllItems();
                $product = array();
                foreach ($orderItems as $item) {
                    if ($item->getBaseRowTotal() > 0) {
                        $product[] = [
                            'entity_id' => (int)$item->getId(),
                            'quantity' => (int)$item->getQtyOrdered(),
                            'description' => $item->getDescription(),
                            'name' => $item->getName(),
                            'sku' => $item->getSku(),
                            'product_type' => $item->getProductType(),
                            'price' => (double)$item->getPrice()
                        ];
                    }
                }
                if ($seller_id == $order_data[0]["seller_id"]) {
                    $order_data[0]["product_list"] = $product;
                    $res["code"] = 0;
                    $res["message"] = "get data success!";
                    $res["result"]["order"] = $order_data;
                }
            } catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        return $res;
    }
    /**
     * {@inheritdoc}
     */
    public function orderCancel($OrderId, $customerId)
    {
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        if (count($seller->getData())>0) {
            $seller_id = $seller->getData()[0]['seller_id'];
        } else {
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $order_controller = $objectManager->create("Lof\MarketPlace\Controller\Marketplace\Order");
        $res = ["code" => 405, "message" => "Get data failed"];

        if ($order = $order_controller->_initOrder($OrderId, $seller_id)) {
            $flag =$helper->cancelorder($order, $seller_id);
            if ($flag) {
                $paymentCode = '';
                $paymentMethod = '';
                if ($order->getPayment()) {
                    $paymentCode = $order->getPayment()->getMethod();
                }

                $trackingcoll = $this->getCollection()
                    ->addFieldToFilter('order_id', $OrderId)
                    ->addFieldToFilter('seller_id', $seller_id);
                foreach ($trackingcoll as $tracking) {
                    $tracking->setTrackingNumber('canceled');
                    $tracking->setCarrierName('canceled');
                    $tracking->setIsCanceled(1);
                    $tracking->setStatus('canceled');
                    $tracking->save();
                }
                $res = ["code" => 0, "message" => "update data success"];
            }
        }
        return $res;
    }
    /**
     * {@inheritdoc}
     */
    public function createSellerOrder($orderId, $customerId)
    {
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        if (count($seller->getData())>0) {
            $message = "We can not create seller order at the time.";
            if ($this->helper->createSellerOrder($orderId)) {
                $message = "The order of sellers were created completely.";
            }
        } else {
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        return $message;
    }
}
