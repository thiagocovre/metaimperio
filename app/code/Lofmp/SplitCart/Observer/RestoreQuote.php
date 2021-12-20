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
 * @package    Lofmp_SplitCart
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SplitCart\Observer;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Exception\NoSuchEntityException;
use Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem\CollectionFactory;
use Lofmp\SplitCart\Helper\ConfigData;

/**
 * Class RestoreQuote
 * @package Lofmp\SplitCart\Observer
 */
class RestoreQuote implements ObserverInterface {

    private $orderInfo;

    private $tempQuoteItemCollectionFactory;

    private $objectManager;

    private $productRepository;

    private $cart;

    private $moduleConfig;

    /**
     * RestoreQuote constructor.
     * @param ObjectManagerInterface $objectManager
     * @param \Magento\Sales\Api\Data\OrderInterface $orderInfo
     * @param ProductRepositoryInterface $productRepository
     * @param CollectionFactory $tempQuoteItemCollectionFactory
     * @param CustomerCart $cart
     * @param ConfigData $moduleConfig
     */
    public function __construct(ObjectManagerInterface $objectManager,
                                \Magento\Sales\Api\Data\OrderInterface $orderInfo,
                                ProductRepositoryInterface $productRepository,
                                CollectionFactory $tempQuoteItemCollectionFactory,
                                CustomerCart $cart,
                                ConfigData $moduleConfig)
    {
        $this->objectManager = $objectManager;
        $this->orderInfo = $orderInfo;
        $this->productRepository = $productRepository;
        $this->tempQuoteItemCollectionFactory = $tempQuoteItemCollectionFactory;
        $this->cart = $cart;
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($this->moduleConfig->isEnabled()) {
            $orderId = (int)$observer->getEvent()->getOrder_ids()[0];
            $order = $this->orderInfo->loadByIncrementId($orderId);
            $quoteId = $order->getQuoteId();

            $tempItemCollection = $this->tempQuoteItemCollectionFactory->create()
                ->addFieldToFilter('quote_id', ['eq' => $quoteId]);

            if (count($tempItemCollection)) {
                foreach ($tempItemCollection as $item) {
                    $infoBuyRequest = json_decode($item->getInfoBuyRequest(), true);
                    $qty = $item->getQty();

                    $filter = new \Zend_Filter_LocalizedToNormalized(
                        ['locale' => $this->objectManager->get(
                            \Magento\Framework\Locale\ResolverInterface::class
                        )->getLocale()]
                    );

                    $infoBuyRequest['qty'] = $filter->filter($qty);

                    $product = $this->_initProduct($infoBuyRequest['product']);
                    $related = isset($infoBuyRequest['related_product']) ? $infoBuyRequest['related_product'] : "";

                    $this->cart->addProduct($product, $infoBuyRequest);
                    if (!empty($related)) {
                        $this->cart->addProductsByIds(explode(',', $related));
                    }

                    $this->cart->save();

                    $item->delete();
                }
            }
        }
    }

    /**
     * @param $productId
     * @return bool|\Magento\Catalog\Api\Data\ProductInterface
     */
    protected function _initProduct($productId)
    {
        if ($productId) {
            $storeId = $this->objectManager->get(
                \Magento\Store\Model\StoreManagerInterface::class
            )->getStore()->getId();
            try {
                return $this->productRepository->getById($productId, false, $storeId);
            } catch (NoSuchEntityException $e) {
                return false;
            }
        }
        return false;
    }
}