<?php
namespace Lof\MarketPlace\Controller\Marketplace\Seller\Saverating;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Seller\Saverating
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Seller\Saverating implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Model\SellerFactory $sellerFactory, \Lof\MarketPlace\Model\Sender $sender, \Lof\MarketPlace\Helper\Data $helper, \Lof\MarketPlace\Helper\Url $url, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Url $frontendUrl, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $sellerFactory, $sender, $helper, $url, $filesystem, $frontendUrl, $resultPageFactory);
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
