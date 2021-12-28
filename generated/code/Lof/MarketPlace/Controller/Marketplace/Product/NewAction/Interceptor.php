<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\NewAction;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\NewAction
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Model\SellerFactory $sellerFactory, \Lof\MarketPlace\Model\GroupFactory $groupFactory, \Magento\Framework\Url $frontendUrl, \Magento\Framework\Registry $registry, \Magento\Catalog\Model\ProductFactory $productFactory, ?\Magento\Store\Model\StoreFactory $storeFactory, \Lof\MarketPlace\Helper\Data $helper, \Magento\Framework\App\RequestInterface $request, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $sellerFactory, $groupFactory, $frontendUrl, $registry, $productFactory, $storeFactory, $helper, $request, $resultPageFactory);
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
