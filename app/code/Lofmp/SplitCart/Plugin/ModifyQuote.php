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
namespace Lofmp\SplitCart\Plugin;

use Magento\Checkout\Model\Cart as CustomerCart;
use Magento\Framework\Controller\Result\RedirectFactory;
use Lofmp\SplitCart\Model\TempQuoteItemFactory;
use Magento\Quote\Model\ResourceModel\Quote\Item\Option\Collection;
use Lofmp\SplitCart\Helper\ConfigData;

/**
 * Class ModifyQuote
 * @package Lofmp\SplitCart\Plugin
 */
class ModifyQuote {

    private $cart;

    private $tempQuoteItemFactory;

    private $quoteItemOptionCollection;

    private $moduleConfig;

    private $resultRedirectFactory;

    /**
     * ModifyQuote constructor.
     * @param CustomerCart $cart
     * @param TempQuoteItemFactory $tempQuoteItemFactory
     * @param Collection $quoteItemOptionCollection
     * @param ConfigData $configData
     * @param RedirectFactory $redirectFactory
     */
    public function __construct(
        CustomerCart $cart,
        TempQuoteItemFactory $tempQuoteItemFactory,
        Collection $quoteItemOptionCollection,
        ConfigData $configData,
        RedirectFactory $redirectFactory
    )
    {
        $this->cart = $cart;
        $this->tempQuoteItemFactory = $tempQuoteItemFactory;
        $this->quoteItemOptionCollection = $quoteItemOptionCollection;
        $this->moduleConfig = $configData;
        $this->resultRedirectFactory = $redirectFactory;
    }

    /**
     * @param \Magento\Checkout\Controller\Index\Index $subject
     * @return null
     */
    public function beforeExecute(\Magento\Checkout\Controller\Index\Index $subject){
        if($this->moduleConfig->isEnabled()){
            $selectedProductIds = $subject->getRequest()->getParam('productIds');

            if($selectedProductIds != ""){
                $selectedProductIds = array_map('intval', explode(',', $selectedProductIds));
                $quote = $this->cart->getQuote();
                $items = $quote->getAllItems();
                $quoteId = $quote->getId();

                foreach($items as $item){
                    $productId = $item->getId();

                    if(!in_array($productId, $selectedProductIds)){
                        $infoBuyRequest = $item->getBuyRequest()->getData();
                        $infoBuyRequest = json_encode($infoBuyRequest);

                        $tempQuoteItem = $this->tempQuoteItemFactory->create();
                        $tempQuoteItem->setQuoteId($quoteId);
                        $tempQuoteItem->setProductId($item->getProductId());
                        $tempQuoteItem->setQty($item->getQty());
                        $tempQuoteItem->setInfoBuyRequest($infoBuyRequest);

                        $tempQuoteItem->save();

                        $this->cart->removeItem($item->getItemId())->save();
                    }
                }
            }
        }

        return null;
    }
}