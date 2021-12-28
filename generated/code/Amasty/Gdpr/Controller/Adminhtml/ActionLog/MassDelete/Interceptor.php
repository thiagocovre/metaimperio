<?php
namespace Amasty\Gdpr\Controller\Adminhtml\ActionLog\MassDelete;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\ActionLog\MassDelete
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\ActionLog\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Ui\Component\MassAction\Filter $filter, \Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\ResourceModel\ActionLog\CollectionFactory $actionLogCollectionFactory, \Amasty\Gdpr\Model\ActionLogRepository $actionLogRepository)
    {
        $this->___init();
        parent::__construct($filter, $context, $actionLogCollectionFactory, $actionLogRepository);
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
