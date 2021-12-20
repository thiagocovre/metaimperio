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
 * Rating Model
 */
class Rating extends \Magento\Framework\Model\AbstractModel
{	
	 /**
     * Define resource model
     */
    protected function _construct() {
        $this->_init ( 'Lof\MarketPlace\Model\ResourceModel\Rating' );
    }
 
    public function getSellerRatings(){
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check_auth = $helper->checkAuth();
        $res = Config::RES_RESULT;
        if ($check_auth) {
        	$seller_id = $helper->getAPISellerID($check_auth);
        	$data = $this->getCollection()->addFieldToFilter('seller_id',$seller_id)->getData();
        	foreach ($data as &$value) {
        		$value["rating_id"] 		= (int)$value["rating_id"];
        		$value["seller_id"] 	  	= (int)$value["seller_id"];
        		$value["customer_id"] 	  	= (int)$value["customer_id"];
        		$value["rate1"] 	  		= (int)$value["rate1"];
        		$value["rate2"] 	  		= (int)$value["rate2"];
        		$value["rate3"] 	  		= (int)$value["rate3"];
        		$value["rating"] 		  	= (int)$value["rating"];
        	}
        	$res = [
	            "code" => 0,
	            "message" => "Get data success",
	            "result" => [
	                	"rating" => $data
	            	]
            ];
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

    public function getSellerRatingsByID( $id ){
    	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check_auth = $helper->checkAuth();
        $res = Config::RES_RESULT;
        if ($check_auth) {
        	$seller_id = $helper->getAPISellerID($check_auth);
        	$data = $this->getCollection()
        						->addFieldToFilter('seller_id',array('eq' => $seller_id))
        						->addFieldToFilter('rating_id', array('eq' => $id))->getFirstItem()->getData();

     		if($data){
	    		$data["rating_id"] 		= (int)$data["rating_id"];
        		$data["seller_id"] 	  	= (int)$data["seller_id"];
        		$data["customer_id"] 	= (int)$data["customer_id"];
        		$data["rate1"] 	  		= (int)$data["rate1"];
        		$data["rate2"] 	  		= (int)$data["rate2"];
        		$data["rate3"] 	  		= (int)$data["rate3"];
        		$data["rating"] 		= (int)$data["rating"];
     		}

        	$res = [
	            "code" => 0,
	            "message" => "Get data success",
	            "result" => [
	                	"review" => $data
	            	]
            ];
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
    }
    
}