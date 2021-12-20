<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Consents\MassDelete;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Consents\MassDelete
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Consents\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\Consent\ResourceModel\CollectionFactory $collectionFactory, \Amasty\Gdpr\Model\Consent\Repository $repository, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $collectionFactory, $repository, $filter, $logger);
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
