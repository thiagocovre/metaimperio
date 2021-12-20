<?php

namespace Lof\MarketPlace\Model;

use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;

Class UpdateStock implements \Lof\MarketPlace\Api\UpdateStockRepositoryInterface

{
    protected $request;
    protected $sellerProduct;
    protected $productFactory;
    protected $customerFactory;
    protected $sellerFactory;
    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    protected $_stockRegistry;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $resourceModel;

    protected $storeManager;
    protected $linkManagement;
    protected $product;

    public function __construct(Request $request,
                                SellerProductFactory $sellerProduct,
                                ProductFactory $productFactory,
                                Product $product,
                                CustomerFactory $customerFactory,
                                SellerFactory $sellerFactory,
                                \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                CategoryLinkManagementInterface $linkManagement = null,
                                \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
    )
    {
        $this->request         = $request;
        $this->sellerProduct   = $sellerProduct;
        $this->productFactory  = $productFactory;
        $this->customerFactory = $customerFactory;
        $this->sellerFactory   = $sellerFactory;
        $this->storeManager     = $storeManager;
        $this->linkManagement   = $linkManagement;
        $this->_stockRegistry = $stockRegistry;
        $this->product = $product;
    }
    /**
     * @inheritdoc
     * @param mixed $product
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws NoSuchEntityException
     */
    public function saveSellerStock($product)
    {
        $products[] =$product;
        $productss = $this->product->load($products[0]["product_id"]);
        $stockItem = $this->_stockRegistry->getStockItem($products[0]["product_id"]); // load stock of that product
        $stockItem->setData('is_in_stock',$products[0]['is_in_stock']); //set updated data as your requirement
        $stockItem->setQty($products[0]['qty']); //set updated quantity
        $stockItem->setData('use_config_notify_stock_qty',1);
        $stockItem->save(); //save stock of item
        $productss->setQty($products[0]['qty']);
        $productss->setSellerId($products[0]['seller_id']);
        $productss->save(); //  also save product
        $data['product'] = [];
        $data['product']['product_id'] = $products[0]["product_id"];
        $data['product']['sku'] = $products[0]["sku"];
        $data['product']['name'] = $productss->getName();
        $data['product']['seller_id'] = $productss->getSellerId();
        $data['product']['price'] = $productss->getPrice();
        $data['product']['qty'] = $productss->getQty();
        $res['re'] = [ "success" => true, "results" =>$data];
        return $res;
    }
    /**
     * @inheritdoc
     * @param mixed $product
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @throws NoSuchEntityException
     */
    public function saveSellerProductPrice($product)
    {

        $products[] =$product;
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $res = Config::RES_RESULT;
        if($product){
            $seller_id = $products[0]['seller_id'];
            if($seller_id)
            {
                $productCollectionFactory = $objectManager->get('\Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
                $collection = $productCollectionFactory->create();
                $collection->addFieldToFilter('seller_id', $seller_id);
                $attributeCode = 'price';
                $entityType = 'catalog_product';
                $attributeInfo = $objectManager->get(\Magento\Eav\Model\Entity\Attribute::class)->loadByCode($entityType, $attributeCode);
                $attribteId = $attributeInfo->getAttributeId();

                $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
                $connection = $resource->getConnection();
                $tableName = $resource->getTableName('catalog_product_entity_decimal');

                foreach ($products as $value) {
                    $collection->addFieldToFilter('entity_id', $value["product_id"]);
                    if($collection->getSize() > 0){
                        $query = "UPDATE ". $tableName ." SET value = ". $value["price"] ." WHERE attribute_id = ". $attribteId ." AND entity_id =" . $value["product_id"];
                       $productCore = $this->productFactory->create()->load($value['product_id']);
                       $productCore->setPrice($value['price'])->save();
                        if($connection->query($query)){
                            $res = [ "code" => 0, "message" => "Save data success"];
                        }
                    }
                }
            }
        }else{
            throw new NoSuchEntityException(__('Sorry Customer has not register seller account'));
        }
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

}