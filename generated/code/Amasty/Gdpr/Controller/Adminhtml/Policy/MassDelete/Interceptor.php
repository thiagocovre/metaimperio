<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Policy\MassDelete;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Policy\MassDelete
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Policy\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\ResourceModel\Policy\CollectionFactory $policyCollectionFactory, \Amasty\Gdpr\Api\PolicyRepositoryInterface $policyRepository)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $policyCollectionFactory, $policyRepository);
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
