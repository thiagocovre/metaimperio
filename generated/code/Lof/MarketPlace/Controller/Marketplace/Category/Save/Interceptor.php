<?php
namespace Lof\MarketPlace\Controller\Marketplace\Category\Save;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Category\Save
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Category\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, \Magento\Store\Model\StoreManagerInterface $storeManager, ?\Magento\Eav\Model\Config $eavConfig = null)
    {
        $this->___init();
        parent::__construct($context, $resultRawFactory, $resultJsonFactory, $layoutFactory, $dateFilter, $storeManager, $eavConfig);
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
