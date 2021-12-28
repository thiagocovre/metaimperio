<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Delete;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Delete
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Delete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Amasty\GdprCookie\Api\CookieGroupsRepositoryInterface $cookieGroupRepository)
    {
        $this->___init();
        parent::__construct($context, $logger, $cookieGroupRepository);
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
