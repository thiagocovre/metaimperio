<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Edit;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Edit
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Url $frontendUrl, \Magento\Framework\Registry $registry, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Helper\Data $helper, ?\Magento\Store\Model\StoreFactory $storeFactory, ?\Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory)
    {
        $this->___init();
        parent::__construct($context, $productFactory, $resultPageFactory, $frontendUrl, $registry, $customerSession, $helper, $storeFactory, $productRepository, $resultForwardFactory);
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
