<?php
namespace Lofmp\MultiShipping\Controller\Marketplace\Settings\Save;

/**
 * Interceptor class for @see \Lofmp\MultiShipping\Controller\Marketplace\Settings\Save
 */
class Interceptor extends \Lofmp\MultiShipping\Controller\Marketplace\Settings\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Model\SellerFactory $sellerFactory, \Magento\Framework\Url $frontendUrl, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $sellerFactory, $frontendUrl, $resultPageFactory);
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
