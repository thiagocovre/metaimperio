<?php
namespace Lof\MarketPlace\Controller\Seller\View;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Seller\View
 */
class Interceptor extends \Lof\MarketPlace\Controller\Seller\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Store\Model\StoreManager $storeManager, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Lof\MarketPlace\Model\Seller $sellerModel, \Magento\Framework\Registry $coreRegistry, \Lof\MarketPlace\Model\Layer\Resolver $layerResolver, \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory, \Lof\MarketPlace\Helper\Data $sellerHelper)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $resultPageFactory, $sellerModel, $coreRegistry, $layerResolver, $resultForwardFactory, $sellerHelper);
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
