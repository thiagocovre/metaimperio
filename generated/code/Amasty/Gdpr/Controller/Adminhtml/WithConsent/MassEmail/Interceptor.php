<?php
namespace Amasty\Gdpr\Controller\Adminhtml\WithConsent\MassEmail;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\WithConsent\MassEmail
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\WithConsent\MassEmail implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Ui\Component\MassAction\Filter $filter, \Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\ResourceModel\WithConsent\CollectionFactory $withConsentCollectionFactory, \Amasty\Gdpr\Model\ResourceModel\ConsentQueue\CollectionFactory $consentQueueCollectionFactory)
    {
        $this->___init();
        parent::__construct($filter, $context, $withConsentCollectionFactory, $consentQueueCollectionFactory);
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
