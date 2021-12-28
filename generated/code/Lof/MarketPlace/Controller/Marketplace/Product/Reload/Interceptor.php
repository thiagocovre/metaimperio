<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Reload;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Reload
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Reload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $registry, ?\Magento\Store\Model\StoreFactory $storeFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Lof\MarketPlace\Helper\Data $helper, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $registry, $storeFactory, $productFactory, $helper, $customerSession, $request, $resultPageFactory);
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
