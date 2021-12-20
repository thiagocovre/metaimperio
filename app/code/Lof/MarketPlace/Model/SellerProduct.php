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

use Lof\MarketPlace\Helper\Data;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Seller Model
 */
class SellerProduct extends \Magento\Framework\Model\AbstractModel implements \Lof\MarketPlace\Api\SellerProductsRepositoryInterface
{   
    /**
     * Seller's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const STATUS_PENDING = 2;

    /**
     * Product collection factory
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    //protected $_productCollectionFactory;

    /** @var \Magento\Store\Model\StoreManagerInterface */
    protected $_storeManager;

    /**
     * URL Model instance
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    protected $_scopeConfig;
    protected $helper;


    /**
     * @param \Magento\Framework\Model\Context                          $context                  
     * @param \Magento\Framework\Registry                               $registry                 
     * @param \Magento\Store\Model\StoreManagerInterface                $storeManager             
     * @param \Lof\MarketPlace\Model\ResourceModel\Product|null                      $resource                 
     * @param \Lof\MarketPlace\Model\ResourceModel\Product\Collection|null           $resourceCollection       
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory 
     * @param \Magento\Store\Model\StoreManagerInterface                $storeManager             
     * @param \Magento\Framework\UrlInterface                           $url                      
     * @param \Magento\Framework\App\Config\ScopeConfigInterface        $scopeConfig              
     * @param array                                                     $data                     
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\MarketPlace\Model\ResourceModel\SellerProduct $resource = null,
        \Lof\MarketPlace\Model\ResourceModel\SellerProduct\Collection $resourceCollection = null,
        \Magento\Catalog\Model\ProductFactory $productCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Data $helper,
        array $data = []
        ) {
        $this->_storeManager = $storeManager;
        $this->_url = $url;
        $this->helper = $helper;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }



    /**
     * Initialize customer model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Lof\MarketPlace\Model\ResourceModel\SellerProduct');
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [0 => __('Not Submited'),1 => __('Pending'), 2 => __('Approved'),3 => __('Unapproved'),];
    }


    public function getProducts($seller_id, $entity_id = null, $arttributeToSelect='*')
    {
        $data = [];
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $productCollectionFactory->create();
        $collection->addFieldToFilter('seller_id', $seller_id);
        if($entity_id){
            $collection->addFieldToFilter('entity_id', $entity_id);
        }
        $collection->addAttributeToSelect($arttributeToSelect);
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        foreach ($collection as $k => $product) {
            $product_data = $product->getData();
//            return $product_data;
//            $product_data['thumbnail'] = $baseUrl .'catalog/product'. $product_data['thumbnail'];
//            $product_data['image'] = $baseUrl .'catalog/product'. $product_data['image'];
//            $product_data['entity_id'] = (int)$product_data['entity_id'];
//            $product_data['seller_id'] = (int)$product_data['seller_id'];
//            $product_data['attribute_set_id'] = (int)$product_data['attribute_set_id'];
//            $product_data['status'] = (int)$product_data['status'];
//            $product_data['price'] = (float)$product_data['price'];
            if($entity_id){
                $data = $product_data;
            }else{
                $data[] = $product_data;
            }
        }
        return $data;
    }
    public function getSellerProducts($seller_id)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check = $this->helper->checkAuth(true);
        $res = Config::RES_RESULT;
        if ($check) {
            $sellerId = $helper->getAPISellerID($check);
            $res = [
                "code" => 0,
                "message" => "Get data success",
                "result" => [
                        "products" => $this->getProducts($seller_id)
                    ]
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

    public function getListSellersProduct($id)
    {
        $res = [
                "code" => 0,
                "message" => "Get data success",
                "result" => [
                        "products" => $this->getProducts($id)
                    ]
            ];
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }
}