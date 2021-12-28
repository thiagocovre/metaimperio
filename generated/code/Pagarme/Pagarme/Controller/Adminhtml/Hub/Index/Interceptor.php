<?php
namespace Pagarme\Pagarme\Controller\Adminhtml\Hub\Index;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Adminhtml\Hub\Index
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Adminhtml\Hub\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\App\Config\Storage\WriterInterface $configWriter, \Magento\Framework\App\Cache\Manager $cacheManager, \Magento\Framework\App\RequestInterface $request, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $configWriter, $cacheManager, $request, $storeManager);
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
