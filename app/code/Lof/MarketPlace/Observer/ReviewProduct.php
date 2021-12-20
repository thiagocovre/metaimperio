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
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Observer;

use Lof\MarketPlace\Helper\Seller;
use Magento\Framework\Event\ObserverInterface;

class ReviewProduct implements ObserverInterface
{
     /**
     * @var  \Lof\MarketPlace\Helper\Data
     */
    protected $helper;
    /**
     * @var Seller
     */
    protected $sellerHelper;
    /**
     * @var   \Magento\Customer\Model\Session
     */
    private $customerSession;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\ResourceConnection $resource,
        \Lof\MarketPlace\Helper\Data $helper,
        Seller $sellerHelper)
    {
        $this->customerSession = $customerSession;
        $this->helper          = $helper;
        $this->sellerHelper          = $sellerHelper;
         $this->_resource = $resource;
    }

     /**
     * Upgrade customer password hash when customer has logged in
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $config_event = $this->helper->getConfig('general_settings/enable');
        if($config_event) {
             /**
             * Create object instance
             */
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
           
            $product = $observer->getProduct();

            $reviewFactory = $objectManager->create('Magento\Review\Model\Review');
            $review  = $objectManager->create('Lof\MarketPlace\Model\Review');

            $connection = $this->_resource->getConnection();
            $table_name = $this->_resource->getTableName('rating_option_vote');

            $reviewFactory->getEntitySummary($product,$this->helper->getStoreId());

            $reviewsCount = $product->getRatingSummary()->getReviewsCount();
             if($product->getId()) {
                if($data = $reviewFactory->getCollection()->addFieldToFilter('entity_pk_value',$product->getId())->getLastItem()->getData()) {

                    $rating = $connection->fetchCol(" SELECT value FROM ".$table_name." WHERE entity_pk_value = ".$product->getId()." AND review_id=".$data['review_id']);
                    if($rating) {
                        $data['rating'] = $rating[0];
                    }
                    $data['product_id'] = $product->getId();
                    $data['status'] = $data['status_id'];
                    $data['seller_id'] = $this->sellerHelper->getSellerIdByProduct($product->getId());
                    $data['customer_id'] = $this->helper->getCustomerId();
                    
                    if(count($review->load($data['review_id'],'review_id')->getData()) == 0) {
                        $review->setData($data)->save();
                    }
                   
                }
            }
            
        }
        return;
    }
}