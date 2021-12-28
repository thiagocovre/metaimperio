<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\MassDelete;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\MassDelete
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Amasty\GdprCookie\Model\ResourceModel\CookieGroup\CollectionFactory $cookieGroupCollectionFactory, \Amasty\GdprCookie\Api\CookieGroupsRepositoryInterface $cookieGroupRepository)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $cookieGroupCollectionFactory, $cookieGroupRepository);
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
