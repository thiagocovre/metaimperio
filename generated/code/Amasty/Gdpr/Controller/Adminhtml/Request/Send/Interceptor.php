<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Request\Send;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Request\Send
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Request\Send implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\ResourceModel\DeleteRequest\CollectionFactory $requestCollectionFactory, \Amasty\Gdpr\Model\DeleteRequest\Notifier $notifier)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $requestCollectionFactory, $notifier);
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
