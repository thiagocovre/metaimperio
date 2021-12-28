<?php
namespace Pagarme\Pagarme\Controller\Adminhtml\Plans\PlanAction;

/**
 * Interceptor class for @see \Pagarme\Pagarme\Controller\Adminhtml\Plans\PlanAction
 */
class Interceptor extends \Pagarme\Pagarme\Controller\Adminhtml\Plans\PlanAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\Message\Factory $messageFactory, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Pagarme\Pagarme\Helper\ProductHelper $productHelper, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreRegistry, $messageFactory, $productCollectionFactory, $resultJsonFactory, $productHelper, $storeManager);
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
