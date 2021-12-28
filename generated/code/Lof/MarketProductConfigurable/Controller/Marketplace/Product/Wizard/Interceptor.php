<?php
namespace Lof\MarketProductConfigurable\Controller\Marketplace\Product\Wizard;

/**
 * Interceptor class for @see \Lof\MarketProductConfigurable\Controller\Marketplace\Product\Wizard
 */
class Interceptor extends \Lof\MarketProductConfigurable\Controller\Marketplace\Product\Wizard implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\Registry $registry, ?\Magento\Store\Model\StoreFactory $storeFactory = null)
    {
        $this->___init();
        parent::__construct($context, $productFactory, $request, $registry, $storeFactory);
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
