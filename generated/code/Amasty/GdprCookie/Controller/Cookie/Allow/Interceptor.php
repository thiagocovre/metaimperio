<?php
namespace Amasty\GdprCookie\Controller\Cookie\Allow;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Cookie\Allow
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Cookie\Allow implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Amasty\GdprCookie\Model\CookieManager $cookieManager, \Magento\Customer\Model\Session $session, \Amasty\GdprCookie\Model\CookieConsentLogger $consentLogger)
    {
        $this->___init();
        parent::__construct($context, $cookieManager, $session, $consentLogger);
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
