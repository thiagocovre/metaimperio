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
namespace Lofmp\SplitCart\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\ObjectManagerInterface;
use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem\CollectionFactory;

/**
 * Class RestoreQuote
 * @package Lofmp\SplitCart\Block
 */
class RestoreQuote extends \Magento\Framework\View\Element\Template {

    private $cart;

    private $tempQuoteItemCollectionFactory;

    private $objectManager;

    private $productRepository;

    /**
     * RestoreQuote constructor.
     * @param Template\Context $context
     * @param array $data
     * @param ObjectManagerInterface $objectManager
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerCart $cart
     * @param CollectionFactory $tempQuoteItemCollectionFactory
     */
    public function __construct(
        Template\Context $context, array $data = [],
        ObjectManagerInterface $objectManager,
        ProductRepositoryInterface $productRepository,
        CustomerCart $cart,
        CollectionFactory $tempQuoteItemCollectionFactory
    ){
        $this->objectManager = $objectManager;
        $this->productRepository = $productRepository;
        $this->cart = $cart;
        $this->tempQuoteItemCollectionFactory = $tempQuoteItemCollectionFactory;
        parent::__construct($context, $data);
    }

    public function _construct()
    {
        $currentUrl = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        $ignoreUrls = [
            $this->getUrl('checkout'),
            $this->getUrl('checkout/index'),
            $this->getUrl('checkout/index/index'),
            $this->getUrl('checkout/cart/add'),
            $this->getUrl('checkout/onepage/success')
        ];

        if(!in_array($currentUrl, $ignoreUrls)){
            $quoteId = $this->cart->getQuote()->getId();

            $tempItemCollection = $this->tempQuoteItemCollectionFactory->create()
                ->addFieldToFilter('quote_id', ['eq' => $quoteId]);
            if(count($tempItemCollection)){
                foreach($tempItemCollection as $item){
                    $infoBuyRequest = json_decode($item->getInfoBuyRequest(), true);

                    if (isset($infoBuyRequest['qty'])) {
                        $filter = new \Zend_Filter_LocalizedToNormalized(
                            ['locale' => $this->objectManager->get(
                                \Magento\Framework\Locale\ResolverInterface::class
                            )->getLocale()]
                        );
                        $infoBuyRequest['qty'] = $filter->filter($infoBuyRequest['qty']);
                    }

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

        parent::_construct();
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