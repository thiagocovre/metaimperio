<?php
namespace Pagarme\Pagarme\Controller\Adminhtml\RecurrenceProducts\Create;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Adminhtml\RecurrenceProducts\Create
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Adminhtml\RecurrenceProducts\Create implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $coreRegistry, \Pagarme\Pagarme\Model\ProductsSubscriptionFactory $productsSubscriptionFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreRegistry, $productsSubscriptionFactory);
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
