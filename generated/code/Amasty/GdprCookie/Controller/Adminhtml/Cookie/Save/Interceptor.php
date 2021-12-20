<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\Cookie\Save;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\Cookie\Save
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\Cookie\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GdprCookie\Model\Repository\CookieRepository $cookieRepository, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupLink $linkResource, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupLink\Collection $linkCollection, \Amasty\GdprCookie\Model\ResourceModel\CookieDescription $descriptionResource, \Amasty\GdprCookie\Model\ResourceModel\CookieDescription\Collection $descriptionCollection, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Amasty\GdprCookie\Model\CookieFactory $cookieFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $cookieRepository, $linkResource, $linkCollection, $descriptionResource, $descriptionCollection, $dataPersistor, $cookieFactory, $logger);
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
