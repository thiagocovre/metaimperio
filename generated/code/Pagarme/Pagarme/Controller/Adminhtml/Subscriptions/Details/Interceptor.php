<?php
namespace Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Details;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Details
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Details implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $coreRegistry)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreRegistry);
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
