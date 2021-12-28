<?php
namespace Lof\MarketPlace\Controller\Adminhtml\Seller\Save;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Adminhtml\Seller\Save
 */
class Interceptor extends \Lof\MarketPlace\Controller\Adminhtml\Seller\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Filesystem $filesystem, \Magento\Store\Model\StoreManagerInterface $store, \Magento\Backend\Helper\Js $jsHelper, \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Customer\Model\CustomerFactory $customer, \Magento\Framework\UrlInterface $urlInterface, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Backend\Model\Session $session, \Magento\Catalog\Model\Product\Url $url, \Lof\MarketPlace\Model\Seller $seller, \Magento\Framework\Escaper $escaper, \Lof\MarketPlace\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $filesystem, $store, $jsHelper, $customerFactory, $customerRepository, $customer, $urlInterface, $transportBuilder, $scopeConfig, $session, $url, $seller, $escaper, $helper);
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
