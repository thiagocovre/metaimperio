<?php
namespace Lof\MarketProductConfigurable\Controller\Marketplace\Product\Attribute\GetAttributes;

/**
 * Interceptor class for @see \Lof\MarketProductConfigurable\Controller\Marketplace\Product\Attribute\GetAttributes
 */
class Interceptor extends \Lof\MarketProductConfigurable\Controller\Marketplace\Product\Attribute\GetAttributes implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Json\Helper\Data $jsonHelper, \Magento\ConfigurableProduct\Model\AttributesListInterface $attributesList)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $jsonHelper, $attributesList);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
