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
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Block\Product;

use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Model\Context as CustomerContext;

class Export extends \Magento\Framework\View\Element\Template
{
    /**
     * Group Collection
     */
    protected $_sellerCollection;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $_sellerHelper;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;
     /**
     *
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;
    /**
     *
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection
     */
    protected $attributeSet;
    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

     /**
     * @var \Magento\ImportExport\Model\Source\Export\EntityFactory
     */
    protected $_entityFactory;
    protected $productFactory;

    /**
     * @var \Magento\ImportExport\Model\Source\Export\FormatFactory
     */
    protected $_formatFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context         
     * @param \Magento\Framework\Registry                      $registry        
     * @param \Lof\MarketPlace\Helper\Data                           $sellerHelper     
     * @param \Lof\MarketPlace\Model\Seller                           $sellerCollection 
     * @param array                                            $data            
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Lof\MarketPlace\Helper\Data $sellerHelper,
        \Lof\MarketPlace\Model\Seller $sellerCollection,
        \Magento\Framework\App\ResourceConnection $resource,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection $attributeSet,
        \Magento\Catalog\Model\Product $product,
        \Magento\ImportExport\Model\Source\Export\EntityFactory $entityFactory,
        \Magento\ImportExport\Model\Source\Export\FormatFactory $formatFactory,
        ProductFactory $productFactory,
        array $data = []
        ) {
        parent::__construct($context, $data); 

        $this->_entityFactory    = $entityFactory;
        $this->_formatFactory    = $formatFactory;
        $this->_sellerCollection = $sellerCollection;
        $this->_sellerHelper     = $sellerHelper;
        $this->_coreRegistry     = $registry;
        $this->_resource         = $resource;
        $this->storeManager      = $context->getStoreManager();
        $this->attributeSet      = $attributeSet;
        $this->product           = $product;
        $this->productFactory    = $productFactory;

    }

    public function getEntity() {
        return $this->_entityFactory->create()->toOptionArray();
    }
    public function getFomat() {
        return $this->_formatFactory->create()->toOptionArray();
    }
    /**
     * Retrieve current product model
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }
    
    public function getSellerCollection(){
        $product = $this->getProduct();
        $connection = $this->_resource->getConnection();
        $table_name = $this->_resource->getTableName('lof_marketplace_product');
        $sellerIds = $connection->fetchCol(" SELECT seller_id FROM ".$table_name." WHERE product_id = ".$product->getId());
        if($sellerIds || count($sellerIds) > 0) {
            $collection = $this->_sellerCollection->getCollection()
                ->setOrder('position','ASC')
                ->addFieldToFilter('status',1);
            $collection->getSelect()->where('seller_id IN (?)', $sellerIds);
            return $collection;
        }
        return false;
    }
    /**
     * Get base currency symbol
     *
     * @return string
     */
    public function getBaseCurrency() {
        return $this->storeManager->getStore ()->getBaseCurrencyCode ();
    }
    /**
     * Get Attribute set datas
     *
     * @return array
     */
    public function getAttributeSet() {
        return $this->attributeSet->toOptionArray ();
    }
    /**
     * Getting product data
     *
     * @param int $productId            
     *
     * @return object $productData
     */
    public function getProductData($productId) {
        return $this->productFactory->create()->load($productId);
    }

    public function _toHtml(){
        //if(!$this->_sellerHelper->getConfig('product_view_page/enable_seller_info')) return;

        return parent::_toHtml();
    }
    /**
     * Get Default Attribute Set Id
     *
     * @return int
     */
    public function getDefaultAttributeSetId() {
        return $this->product->getDefaultAttributeSetId ();
    }

     /**
     * Prepare layout for change buyer
     *
     * @return Object
     */
    public function _prepareLayout() {
        $this->pageConfig->getTitle ()->set(__('Export Product'));
        return parent::_prepareLayout ();
    }

}