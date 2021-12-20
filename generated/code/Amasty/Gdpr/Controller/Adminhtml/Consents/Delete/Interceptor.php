<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Consents\Delete;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Consents\Delete
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Consents\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Amasty\Gdpr\Model\Consent\Repository $repository)
    {
        $this->___init();
        parent::__construct($context, $logger, $repository);
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
