<?php
namespace Lof\MarketPlace\Model\SellersProductRepository;

/**
 * Interceptor class for @see \Lof\MarketPlace\Model\SellersProductRepository
 */
class Interceptor extends \Lof\MarketPlace\Model\SellersProductRepository implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $initializationHelper, \Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory $searchResultsFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Catalog\Api\ProductAttributeRepositoryInterface $attributeRepository, \Magento\Catalog\Model\ResourceModel\Product $resourceModel, \Magento\Catalog\Model\Product\Initialization\Helper\ProductLinks $linkInitializer, \Magento\Catalog\Model\Product\LinkTypeProvider $linkTypeProvider, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Api\FilterBuilder $filterBuilder, \Magento\Catalog\Api\ProductAttributeRepositoryInterface $metadataServiceInterface, \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter, \Magento\Catalog\Model\Product\Option\Converter $optionConverter, \Magento\Framework\Filesystem $fileSystem, \Magento\Framework\Api\ImageContentValidatorInterface $contentValidator, \Magento\Framework\Api\Data\ImageContentInterfaceFactory $contentFactory, \Magento\Catalog\Model\Product\Gallery\MimeTypeExtensionMap $mimeTypeExtensionMap, \Magento\Framework\Api\ImageProcessorInterface $imageProcessor, \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface $extensionAttributesJoinProcessor, ?\Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface $collectionProcessor = null, ?\Magento\Framework\Serialize\Serializer\Json $serializer = null, $cacheLimit = 1000, ?\Magento\Framework\EntityManager\Operation\Read\ReadExtensions $readExtensions = null, ?\Magento\Catalog\Api\CategoryLinkManagementInterface $linkManagement = null)
    {
        $this->___init();
        parent::__construct($productFactory, $initializationHelper, $searchResultsFactory, $collectionFactory, $searchCriteriaBuilder, $attributeRepository, $resourceModel, $linkInitializer, $linkTypeProvider, $storeManager, $filterBuilder, $metadataServiceInterface, $extensibleDataObjectConverter, $optionConverter, $fileSystem, $contentValidator, $contentFactory, $mimeTypeExtensionMap, $imageProcessor, $extensionAttributesJoinProcessor, $collectionProcessor, $serializer, $cacheLimit, $readExtensions, $linkManagement);
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Magento\Catalog\Api\Data\ProductInterface $product, $saveOptions = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'save');
        return $pluginInfo ? $this->___callPlugins('save', func_get_args(), $pluginInfo) : parent::save($product, $saveOptions);
    }
}
