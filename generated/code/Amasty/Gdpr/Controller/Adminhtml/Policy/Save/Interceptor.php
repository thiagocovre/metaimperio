<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Policy\Save;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Policy\Save
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Policy\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\PolicyFactory $policyFactory, \Amasty\Gdpr\Api\PolicyRepositoryInterface $repository, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Amasty\Gdpr\Model\ResourceModel\Policy $policyResource, \Magento\Authorization\Model\UserContextInterface $userContext, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\ResourceModel\PolicyContent\Collection $contentCollection, \Amasty\Gdpr\Model\ResourceModel\PolicyContent $policyContentResource)
    {
        $this->___init();
        parent::__construct($context, $policyFactory, $repository, $dataPersistor, $policyResource, $userContext, $logger, $contentCollection, $policyContentResource);
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
