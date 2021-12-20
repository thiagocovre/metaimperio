<?php
namespace Lof\MarketPlace\Model;
use Lof\MarketPlace\Api\SellerProductInterface;
use Lof\MarketPlace\Model\SellerProductFactory;
use Magento\Catalog\Api\CategoryLinkManagementInterface;
use Magento\Catalog\Api\Data\ProductExtension;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ProductFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Webapi\Rest\Request;
use Lof\MarketPlace\Model\SellerFactory;
class SellerProductManager implements SellerProductInterface
{
    protected $request;
    protected $sellerProduct;
    protected $productFactory;
    protected $customerFactory;
    protected $sellerFactory;
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product
     */
    protected $resourceModel;

    protected $storeManager;
    protected $linkManagement;
    protected $scopeConfig;
    protected $product;

    public function __construct(Request $request,
                                SellerProductFactory $sellerProduct,
                                ProductFactory $productFactory,
                                CustomerFactory $customerFactory,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
                                SellerFactory $sellerFactory,
                                \Magento\Catalog\Model\ResourceModel\Product $resourceModel,
                                \Magento\Store\Model\StoreManagerInterface $storeManager,
                                SellerProduct $product,
                                CategoryLinkManagementInterface $linkManagement = null
    )
    {
        $this->request = $request;
        $this->sellerProduct = $sellerProduct;
        $this->productFactory = $productFactory;
        $this->customerFactory = $customerFactory;
        $this->sellerFactory = $sellerFactory;
        $this->storeManager = $storeManager;
        $this->linkManagement = $linkManagement;
        $this->scopeConfig = $scopeConfig;
        $this->product = $product;
    }

    /**
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function assignProduct($productId, $storeId, $customerId)
    {
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        $status = $this->scopeConfig->getValue('lofmarketplace/seller_settings/approval', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $productOrg = $this->productFactory->create();
        if (count($seller->getData()) > 0) {
            $sellerId = $seller->getData()[0]['seller_id'];
        } else {
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $sellerProduct = $this->sellerProduct->create();
        $collection = $productOrg->getCollection()->addFieldToFilter('entity_id', $productId);
        if ($status == 1) {
            $sellerProductId = $collection->getData()[0]['entity_id'];
            if (count($collection->getData()) > 0) {
                $productSeller = $sellerProduct->load($sellerProductId);
                //status = 2 is approval
                $productOrg->load($sellerProductId)->setSellerId($sellerId)->save();
                $productSeller->setProductId($productId)->setSellerId($sellerId)->setStoreId($storeId)->setStatus(2)->save();
                return true;
            } else {
                $sellerProduct->setProductId($productId)->setSellerId($sellerId)->setStoreId($storeId)->setStatus(2)->save();
                $productOrg->load($sellerProductId)->setSellerId($sellerId)->save();

            }
            return true;
        } else {
            $collection = $productOrg->getCollection()->addFieldToFilter('entity_id', $productId);
            $sellerProductId = $collection->getData()[0]['entity_id'];
            if (count($collection->getData()) > 0) {
                $productSeller = $sellerProduct->load($sellerProductId);
                // status = 1 is pending status
                $productSeller->setProductId($productId)->setSellerId($sellerId)->setStoreId($storeId)->setStatus(1)->save();
                $productOrg->load($sellerProductId)->setSellerId($sellerId)->save();
                return true;
            } else {
                $sellerProduct->setProductId($productId)->setSellerId($sellerId)->setStoreId($storeId)->setStatus(1)->save();
                $productOrg->load($sellerProductId)->setSellerId($sellerId)->save();
            }
            return true;
        }

    }

    /**
     *
     * @return mixed
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setCommissionForSpecialProduct($productId, $commission, $sellerId)
    {
        $collection = $this->sellerProduct->create()->getCollection()->addFieldToFilter('product_id', $productId);
        $modelData = $this->sellerProduct->create()->getCollection()->addFieldToFilter('product_id', $productId);
        $sellerProductId = $modelData->getData()[0]['entity_id'];
        $model = $this->product;
        if (count($collection->getData()) > 0) {
            $model->load($sellerProductId);
            $model->setCommission($commission)->setSellerId($sellerId)
                ->save();
        } else {
            throw new NoSuchEntityException(__('Products with id %1 don\'t exist in seller\'s product', $productId));
        }
        $data['data'] = [];
        $data['data']['product_id'] = $productId;
        $data['data']['commission'] = $model->getCommission();
        $data['data']['seller_id'] = $model->getSellerId();
        $data['data']['entity_id'] = $model->getId();
        return $data;
    }

    /**
     * @inheritdoc
     * @param int $customerId
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function createProduct(\Magento\Catalog\Api\Data\ProductInterface $product, $customerId)
    {
        $products = $this->productFactory->create();
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId)->load();
        $status = $this->scopeConfig->getValue('lofmarketplace/seller_settings/approval', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (count($seller->getData()) > 0) {
            $sellerId = $seller->getData()[0]['seller_id'];
            $storeId = $seller->getData()[0]['store_id'];
        } else {
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        if ($status == 1) {
            $products->setSku($product->getSku())
                ->setName($product->getName())
                ->setAttributeSetId($product->getAttributeSetId())
                ->setPrice($product->getPrice())
                ->setStatus($product->getStatus())
                ->setVisibility($product->getVisibility())
                ->setTypeId($product->getTypeId())
                ->setWeight($product->getWeight())
                ->setMediaGalleryEntries($product->getMediaGalleryEntries())
                ->setExtensionAttributes($product->getExtensionAttributes())->save();
            $sellerProduct = $this->sellerProduct->create();
            $sellerProduct->setProductId($products->getId())->setSellerId($sellerId)->setStoreId($storeId)
                ->setStatus(1)->save();
            $data['product'] = [];
            $data['product']['product_id'] = $products->getId();
            $data['product']['sku'] = $products->getSku();
            $data['product']['name'] = $products->getName();
            $data['product']['price'] = $products->getPrice();
            $data['product']['visibility'] = $products->getVisibility();
            $data['product']['type_id'] = $products->getTypeId();
            $data['product']['seller_id'] = $sellerId;
            $data['product']['customer_id'] = $customerId;
            return $data;
        }else{
            $products->setSku($product->getSku())
                ->setName($product->getName())
                ->setAttributeSetId($product->getAttributeSetId())
                ->setPrice($product->getPrice())
                ->setStatus($product->getStatus())
                ->setVisibility($product->getVisibility())
                ->setTypeId($product->getTypeId())
                ->setWeight($product->getWeight())
                ->setMediaGalleryEntries($product->getMediaGalleryEntries())
                ->setExtensionAttributes($product->getExtensionAttributes())->save();
            $sellerProduct = $this->sellerProduct->create();
            $sellerProduct->setProductId($products->getId())->setSellerId($sellerId)->setStoreId($storeId)->setCustomerId($customerId)
                ->setStatus(1)->save();
            $data['product'] = [];
            $data['product']['product_id'] = $products->getId();
            $data['product']['sku'] = $products->getSku();
            $data['product']['name'] = $products->getName();
            $data['product']['price'] = $products->getPrice();
            $data['product']['visibility'] = $products->getVisibility();
            $data['product']['type_id'] = $products->getTypeId();
            $data['product']['seller_id'] = $sellerId;
            $data['product']['customer_id'] = $customerId;
            return $data;
        }

    }
}