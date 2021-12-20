<?php
namespace Amasty\Gdpr\Controller\Adminhtml\Consents\Save;

/**
 * Interceptor class for @see \Amasty\Gdpr\Controller\Adminhtml\Consents\Save
 */
class Interceptor extends \Amasty\Gdpr\Controller\Adminhtml\Consents\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Amasty\Gdpr\Model\Consent\Repository $repository, \Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Cms\Helper\Page $cmsHelper)
    {
        $this->___init();
        parent::__construct($repository, $context, $logger, $cmsHelper);
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
