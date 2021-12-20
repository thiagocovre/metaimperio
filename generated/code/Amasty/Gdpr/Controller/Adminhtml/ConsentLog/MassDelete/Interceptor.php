<?php
namespace Amasty\Gdpr\Controller\Adminhtml\ConsentLog\MassDelete;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\ConsentLog\MassDelete
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\ConsentLog\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Ui\Component\MassAction\Filter $filter, \Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\ResourceModel\WithConsent\CollectionFactory $consentLogCollectionFactory, \Amasty\Gdpr\Model\Repository\WithConsentRepository $withConsentRepository)
    {
        $this->___init();
        parent::__construct($filter, $context, $consentLogCollectionFactory, $withConsentRepository);
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
