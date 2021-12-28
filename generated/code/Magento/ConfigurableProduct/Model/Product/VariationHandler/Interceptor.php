<?php
namespace Magento\ConfigurableProduct\Model\Product\VariationHandler;

/**
 * Interceptor class for @see \Magento\ConfigurableProduct\Model\Product\VariationHandler
 */
class Interceptor extends \Magento\ConfigurableProduct\Model\Product\VariationHandler implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurableProduct, \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory, \Magento\Eav\Model\EntityFactory $entityFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\Catalog\Model\Product\Gallery\Processor $mediaGalleryProcessor)
    {
        $this->___init();
        parent::__construct($configurableProduct, $attributeSetFactory, $entityFactory, $productFactory, $stockConfiguration, $mediaGalleryProcessor);
    }

    /**
     * {@inheritdoc}
     */
    public function generateSimpleProducts($parentProduct, $productsData)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'generateSimpleProducts');
        return $pluginInfo ? $this->___callPlugins('generateSimpleProducts', func_get_args(), $pluginInfo) : parent::generateSimpleProducts($parentProduct, $productsData);
    }
}
