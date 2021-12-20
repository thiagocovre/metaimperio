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

use Lofmp\SplitCart\Helper\ConfigData;

/**
 * Class SaveQuoteItem
 * @package Lofmp\SplitCart\Plugin
 */
class SaveQuoteItem {
    private $sellerProductCollectionFactory;

    private $moduleConfig;

    /**
     * SaveQuoteItem constructor.
     * @param \Lof\MarketPlace\Model\ResourceModel\SellerProduct\CollectionFactory $sellerProductCollectionFactory
     * @param ConfigData $configData
     */
    public function __construct(
        \Lof\MarketPlace\Model\ResourceModel\SellerProduct\CollectionFactory $sellerProductCollectionFactory,
        ConfigData $configData)
    {
        $this->sellerProductCollectionFactory = $sellerProductCollectionFactory;
        $this->moduleConfig = $configData;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item $subject
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave(\Magento\Quote\Model\Quote\Item $subject){
        if($this->moduleConfig->isEnabled()){
            $sellerId = 0;
            $productId = $subject->getProductId();
            $collection = $this->sellerProductCollectionFactory->create();

            $collection->addFieldToFilter('product_id', ['eq' => $productId]);
            if(!count($collection)){
                $subject->setSellerId(0);
                return null;
            }
            else {
                foreach($collection as $item){
                    $sellerId = $item->getSellerId();
                }
                $subject->setSellerId($sellerId);
                return null;
            }
        }
    }
}