<?php
namespace Amasty\GeoipRedirect\Controller\Redirect\Decline;

/**
 * Interceptor class for @see \Amasty\GeoipRedirect\Controller\Redirect\Decline
 */
class Interceptor extends \Amasty\GeoipRedirect\Controller\Redirect\Decline implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Session\SessionManagerInterface $sessionManager)
    {
        $this->___init();
        parent::__construct($context, $sessionManager);
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
