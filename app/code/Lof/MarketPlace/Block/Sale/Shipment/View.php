<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Block\Sale\Shipment;
use Lof\MarketPlace\Model\OrderFactory;
use Lof\MarketPlace\Model\SellerFactory;
use Lof\MarketPlace\Model\SellerProductFactory;
use Magento\Sales\Api\InvoiceRepositoryInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
class View extends \Magento\Framework\View\Element\Template
{
	
    /**
     * @var \Lof\MarketPlace\Model\ResourceModel\SellerInvoice\Grid\Collection
    */
    protected $invoice;
    /**
     *
     * @var Magento\Framework\App\Action\Session
     */
    protected $session;

    /**
     * @var \Lof\MarketPlace\Model\Seller
    */
    protected $seller;
     /**
     * @var string[]
     */
    protected $states;
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceFormatter;

    /**
     * @var Address\Renderer
     */
    protected $addressRenderer;

    protected $request;
     /**
     * Group service
     *
     * @var \Magento\Customer\Api\GroupRepositoryInterface
     */
    protected $groupRepository;

    protected $order;

    public $helper;

    protected $orderitems;

    protected $orderFactory;

    protected $sellerFactory;

    protected $sellerProductFactory;
     /**
     * Payment data
     *
     * @var \Magento\Payment\Helper\Data
     */
    protected $_paymentData = null;
	/**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession, 
        \Lof\MarketPlace\Model\ResourceModel\SellerInvoice\Grid\Collection $invoice,
        \Lof\MarketPlace\Model\Order $order,
        \Lof\MarketPlace\Model\Seller $seller,
        InvoiceRepositoryInterface $invoiceRepository,
        PriceCurrencyInterface $priceFormatter,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Sales\Model\Order\Address\Renderer $addressRenderer,
        \Lof\MarketPlace\Helper\Data $helper,
        \Magento\Payment\Helper\Data $paymentData,
        \Lof\MarketPlace\Model\Orderitems $orderitems,
        SellerFactory $sellerFactory,
        SellerProductFactory $sellerProductFactory,
        OrderFactory $orderFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->orderitems = $orderitems;
        $this->order = $order;
    	$this->helper = $helper;
    	$this->groupRepository = $groupRepository;
    	$this->request = $context->getRequest();
        $this->states = $invoiceRepository->create()->getStates();
        $this->priceFormatter = $priceFormatter;
        $this->invoice = $invoice;
        $this->seller = $seller;
        $this->addressRenderer = $addressRenderer;
        $this->session           = $customerSession;
        $this->_paymentData = $paymentData;
        $this->orderFactory = $orderFactory;
        $this->sellerFactory = $sellerFactory;
        $this->sellerProductFactory = $sellerProductFactory;

    }

    public function getFormattedAddress()
    { 
        if($this->getOrder()->getShippingAddress()) {
            return $this->addressRenderer->format($this->getOrder()->getShippingAddress(), 'html');
        } else {
            return;
        }
    }

    public function getBillingAddress() {
    	return $this->addressRenderer->format($this->getOrder()->getBillingAddress(), 'html');
    }

    public function getSellerOrder($OrderId) {
        $order = $this->orderFactory->create()->load($OrderId,'order_id');
        return $order;
    }
    /**
     * Get order store name
     *
     * @return null|string
     */
    public function getOrderStoreName()
    {
        if ($this->getOrder()) {
            $storeId = $this->getOrder()->getStoreId();
            if ($storeId === null) {
                $deleted = __(' [deleted]');
                return nl2br($this->getOrder()->getStoreName()) . $deleted;
            }
            $store = $this->_storeManager->getStore($storeId);
            $name = [$store->getWebsite()->getName(), $store->getGroup()->getName(), $store->getName()];
            return implode('<br/>', $name);
        }

        return null;
    }
    /**
     *  get Seller Colection
     *
     * @return Object
     */
     public function getInvoiceCollection(){
        $invoiceCollection = $this->invoice;
        return $invoiceCollection;
    }
    public function getStatus($status) {
        return isset($this->states[$status])? $this->states[$status]->getText():$status;
    }
    /**
     * Get object created at date
     *
     * @param string $createdAt
     * @return mixed
     */
    public function getOrderAdminDate($createdAt)
    {
        return $this->_localeDate->date(new \DateTime($createdAt));
    }
     /**
     * Return name of the customer group.
     *
     * @return string
     */
    public function getCustomerGroupName()
    {
        if ($this->getOrder()) {
            $customerGroupId = $this->getOrder()->getCustomerGroupId();
            try {
                if ($customerGroupId !== null) {
                    return $this->groupRepository->getById($customerGroupId)->getCode();
                }
            } catch (NoSuchEntityException $e) {
                return '';
            }
        }

        return '';
    }
    /**
     * Get All Carriers
     *
     * @return array
     */
    public function getCarriers()
    {
        $carriers = [];
        $carrierInstances = $this->_getCarriersInstances();
        $carriers['custom'] = __('Custom Value');
        foreach ($carrierInstances as $code => $carrier) {
            if ($carrier->isTrackingAvailable()) {
                $carriers[$code] = $carrier->getConfigData('title');
            }
        }
        return $carriers;
    }

    /**
     * @return array
     */
    protected function _getCarriersInstances()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $shippingConfig = $objectManager->create('Magento\Shipping\Model\Config');
        return $shippingConfig->getAllCarriers($this->getShipment()->getStoreId());
    }
      /**
     * Set payment
     *
     * @param Info $payment
     * @return $this
     */
    public function getPayment()
    {
        $paymentInfoBlock = $this->_paymentData->getInfoBlock($this->getOrder()->getPayment(), $this->getLayout());
        $this->setChild('info', $paymentInfoBlock);
        $this->setData('payment', $this->getOrder()->getPayment());
        return $this;
    }
    public function getOrderDate() {
    	return $this->formatDate(
		    $this->getOrderAdminDate($this->getOrder()->getCreatedAt()),
		    \IntlDateFormatter::MEDIUM,
		    true
		);
    }
    public function getOrderItems($product_id) {
        $orderitems = $this->orderitems->getCollection()->addFieldToFilter('seller_id',$this->getSellerId())->addFieldToFilter('order_id',$this->getInvoice()->getOrderId())->addFieldToFilter('product_id',$product_id)->getFirstItem();

        return $orderitems;
    }
     public function getInvoiceId() {
        $path = trim($this->request->getPathInfo(), '/');
        $params = explode('/', $path);
        return end($params);
    }
    public function getShipmentId() {
        $path = trim($this->request->getPathInfo(), '/');
        $params = explode('/', $path);
        return end($params);
    }
    public function getShipment() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $shipment = $objectManager->get('Magento\Sales\Model\Order\Shipment')->load($this->getShipmentId());
        return $shipment;
    }
    public function getInvoice() {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
    	$invoice = $objectManager->get('Magento\Sales\Model\Order\Invoice')->load($this->getInvoiceId());
    	return $invoice;
    }
    public function getSellerInvoice() {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
    	$invoice = $objectManager->get('Magento\Sales\Model\Order\Invoice')->load($this->getInvoiceId(),'invoice_id');
    	return $invoice;
    }
    public function getOrder() {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
    	$order = $objectManager->get('Magento\Sales\Model\Order')->load($this->getShipment()->getOrderId());
    	return $order;
    }
    public function getPriceFomat($price,$base_currency_code) {
        $currencyCode = isset($base_currency_code) ? $base_currency_code : null;
        return $this->priceFormatter->format(
                    $price,
                    false,
                    null,
                    null,
                    $currencyCode
                );
    }
    public function isSeller() {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getId();
            $sellerDatas = $this->sellerFactory->create()->load ( $customerId, 'customer_id' );
            $status =  $sellerDatas->getStatus();
            return $status;
        }
    }
    public function getSellerId() {
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn()) {
            $customerId = $customerSession->getId();
           	$sellerDatas = $this->sellerFactory->create()->load ($customerId, 'customer_id' );
            $id = $sellerDatas ->getId();
            return $id;
        }
    }
    public function getSeller($productid) {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $product = $objectManager->create('Magento\Catalog\Model\Product')->load ( $productid, 'entity_id' );
        $seller_id = $product->getSellerId();
        $sellerDatas = $this->sellerFactory->create()->load ( $seller_id, 'seller_id' );

        return $sellerDatas;
    }
    public function getCurrentUrl()
    {
        return $this->_urlBuilder->getCurrentUrl(); 
    }
    /**
     * Prepare layout for change buyer
     *
     * @return Object
     */
    public function _prepareLayout() {
        $this->pageConfig->getTitle ()->set(__('View Shipment'));
        return parent::_prepareLayout ();
    }
    public function getSellerProducts()
    {
        $sellerId = $this->getSellerId();
        $productIds = [];
        if($sellerId){
            $productModel = $this->sellerProductFactory->create()->getCollection();
            $products = $productModel->addFieldToFilter("seller_id",$sellerId)->load();
            foreach ($products as $product) {
                array_push($productIds, $product->getData("product_id"));
            }
        }
        return $productIds;
    }
     /**
     * @param string $code
     * @return \Magento\Framework\Phrase|string|bool
     */
    public function getCarrierTitle($code)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $carrierFactory = $objectManager->create(
            'Magento\Shipping\Model\CarrierFactory'
        );
        $carrier = $carrierFactory->create($code);
        if ($carrier) {
            return $carrier->getConfigData('title');
        } else {
            return __('Custom Value');
        }
        return false;
    }

    public function trackingAddUrl($orderId = null, $shipmentId = null)
    {
        return $this->_urlBuilder->getUrl(
            'catalog/sales/add',
            [
                'order_id' => $orderId,
                'shipment_id' => $shipmentId,
                '_secure' => $this->getRequest()->isSecure()
            ]
        );
    }
    public function trackingDeleteUrl($orderId = null, $shipmentId = null, $id = null)
    {
        return $this->_urlBuilder->getUrl(
            'catalog/sales/delete',
            [
                'order_id' => $orderId,
                'shipment_id' => $shipmentId,
                'id' => $id,
                '_secure' => $this->getRequest()->isSecure()
            ]
        );
    }
}