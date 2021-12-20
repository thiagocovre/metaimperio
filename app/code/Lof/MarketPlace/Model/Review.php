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

use Magento\Framework\DataObject\IdentityInterface;

/**
 * Review Model
 */
class Review extends \Magento\Framework\Model\AbstractModel
{	
	 /**
     * Define resource model
     */
    protected function _construct() {
        $this->_init ( 'Lof\MarketPlace\Model\ResourceModel\Review' );
    }
 
    public function getSellerReviews(){
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check_auth = $helper->checkAuth();
        $res = [
            "code" => 405,
            "message" => "Get data failed"
        ];
        if ($check_auth) {
        	$seller_id = $helper->getAPISellerID($check_auth);
        	$data = $this->getCollection()->addFieldToFilter('seller_id',$seller_id)->getData();
        	foreach ($data as &$value) {
        		$value["reviewseller_id"] = (int)$value["reviewseller_id"];
        		$value["type"] 	  		  = (int)$value["type"];
        		$value["seller_id"] 	  = (int)$value["seller_id"];
        		$value["customer_id"] 	  = (int)$value["customer_id"];
        		$value["review_id"] 	  = (int)$value["review_id"];
        		$value["product_id"] 	  = (int)$value["product_id"];
        		$value["rating"] 		  = (int)$value["rating"];
        		$value["order_id"] 		  = (int)$value["order_id"];
        		$value["is_public"] 	  = (int)$value["is_public"];
        		$value["status"] 		  = (int)$value["status"];
        	}
        	$res = [
	            "code" => 0,
	            "message" => "Get data success"
            ];
            $res["result"] = [
                "reviews" => $data
            ];
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

    public function getSellerReviewsByID( $id ){
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check_auth = $helper->checkAuth();
        $res = [
            "code" => 405,
            "message" => "Get data failed"
        ];
        if ($check_auth) {
        	$seller_id = $helper->getAPISellerID($check_auth);
        	$data = $this->getCollection()
        						->addFieldToFilter('seller_id',array('eq' => $seller_id))
        						->addFieldToFilter('reviewseller_id', array('eq' => $id))->getFirstItem()->getData();

    		$data["reviewseller_id"] 	= (int)$data["reviewseller_id"];
    		$data["type"] 	  		  	= (int)$data["type"];
    		$data["seller_id"] 	  		= (int)$data["seller_id"];
    		$data["customer_id"] 	  	= (int)$data["customer_id"];
    		$data["review_id"] 	  		= (int)$data["review_id"];
    		$data["product_id"] 	  	= (int)$data["product_id"];
    		$data["rating"] 		  	= (int)$data["rating"];
    		$data["order_id"] 		  	= (int)$data["order_id"];
    		$data["is_public"] 	  		= (int)$data["is_public"];
    		$data["status"] 		  	= (int)$data["status"];

        	$res = [
	            "code" => 0,
	            "message" => "Get data success"
            ];
            $res["result"] = [
                "review" => $data
            ];
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
    }
    
}