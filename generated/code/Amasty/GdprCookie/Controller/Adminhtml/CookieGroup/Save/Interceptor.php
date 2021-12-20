<?php
namespace Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Save;

/**
 * Interceptor class for @see \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Save
 */
class Interceptor extends \Amasty\GdprCookie\Controller\Adminhtml\CookieGroup\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Amasty\GdprCookie\Model\Repository\CookieGroupsRepository $cookieGroupRepository, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupLink $linkResource, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupLink\Collection $linkCollection, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupDescription $descriptionResource, \Amasty\GdprCookie\Model\ResourceModel\CookieGroupDescription\Collection $descriptionCollection, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor, \Amasty\GdprCookie\Model\CookieGroupFactory $cookieGroupFactory, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $cookieGroupRepository, $linkResource, $linkCollection, $descriptionResource, $descriptionCollection, $dataPersistor, $cookieGroupFactory, $logger);
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
