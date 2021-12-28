<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\Cookie\MassDelete;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\Cookie\MassDelete
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\Cookie\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Psr\Log\LoggerInterface $logger, \Amasty\GdprCookie\Model\ResourceModel\Cookie\CollectionFactory $cookieCollectionFactory, \Amasty\GdprCookie\Api\CookieRepositoryInterface $cookieRepository)
    {
        $this->___init();
        parent::__construct($context, $filter, $logger, $cookieCollectionFactory, $cookieRepository);
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
