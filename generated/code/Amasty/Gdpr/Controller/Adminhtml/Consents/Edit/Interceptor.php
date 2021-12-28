<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Consents\Edit;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Consents\Edit
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Consents\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\Gdpr\Model\Consent\Repository $repository)
    {
        $this->___init();
        parent::__construct($context, $repository);
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
