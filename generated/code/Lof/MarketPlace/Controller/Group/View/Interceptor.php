<?php
namespace Lof\MarketPlace\Controller\Group\View;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Group\View
 */
class Interceptor extends \Lof\MarketPlace\Controller\Group\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Store\Model\StoreManager $storeManager, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Lof\MarketPlace\Model\Group $groupModel, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory, \Lof\MarketPlace\Helper\Data $sellerHelper)
    {
        $this->___init();
        parent::__construct($context, $storeManager, $resultPageFactory, $groupModel, $coreRegistry, $resultForwardFactory, $sellerHelper);
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
