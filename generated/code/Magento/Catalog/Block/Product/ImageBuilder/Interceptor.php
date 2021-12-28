<?php
namespace Magento\Catalog\Block\Product\ImageBuilder;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\ImageBuilder
 */
class Interceptor extends \Magento\Catalog\Block\Product\ImageBuilder implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\ImageFactory $helperFactory, \Magento\Catalog\Block\Product\ImageFactory $imageFactory)
    {
        $this->___init();
        parent::__construct($helperFactory, $imageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function setProduct(\Magento\Catalog\Model\Product $product)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setProduct');
        return $pluginInfo ? $this->___callPlugins('setProduct', func_get_args(), $pluginInfo) : parent::setProduct($product);
    }

    /**
     * {@inheritdoc}
     */
    public function setImageId($imageId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setImageId');
        return $pluginInfo ? $this->___callPlugins('setImageId', func_get_args(), $pluginInfo) : parent::setImageId($imageId);
    }

    /**
     * {@inheritdoc}
     */
    public function create(?\Magento\Catalog\Model\Product $product = null, ?string $imageId = null, ?array $attributes = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'create');
        return $pluginInfo ? $this->___callPlugins('create', func_get_args(), $pluginInfo) : parent::create($product, $imageId, $attributes);
    }
}
