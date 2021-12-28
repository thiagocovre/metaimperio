<?php
namespace Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Delete;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Delete
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Adminhtml\Subscriptions\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Message\Factory $messageFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreRegistry, $messageFactory);
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
