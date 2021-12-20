<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\Cookie\Edit;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\Cookie\Edit
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\Cookie\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GdprCookie\Model\Repository\CookieRepository $cookieRepository)
    {
        $this->___init();
        parent::__construct($context, $cookieRepository);
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
