<?php
namespace Lof\MarketPlace\Controller\Seller\CreatePost;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Seller\CreatePost
 */
class Interceptor extends \Lof\MarketPlace\Controller\Seller\CreatePost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\AccountManagementInterface $accountManagement, \Magento\Framework\UrlFactory $urlFactory, \Magento\Framework\Escaper $escaper, \Magento\Customer\Model\Metadata\FormFactory $formFactory, \Magento\Customer\Api\Data\RegionInterfaceFactory $regionInterfaceFactory, \Magento\Customer\Api\Data\AddressInterfaceFactory $addressInterfaceFactory, \Magento\Customer\Model\Registration $registration, \Magento\Customer\Model\CustomerExtractor $customerExtractor, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory, \Magento\Directory\Model\Region $region, \Magento\Customer\Helper\Address $address, \Magento\Customer\Model\Url $url, \Lof\MarketPlace\Model\Seller $seller, \Magento\Store\Model\StoreManagerInterface $storeManagerInterface, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Lof\MarketPlace\Model\Sender $sender, \Lof\MarketPlace\Helper\Data $sellerHelper, \Magento\Customer\Model\Account\Redirect $accountRedirect)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $accountManagement, $urlFactory, $escaper, $formFactory, $regionInterfaceFactory, $addressInterfaceFactory, $registration, $customerExtractor, $subscriberFactory, $region, $address, $url, $seller, $storeManagerInterface, $dataObjectHelper, $sender, $sellerHelper, $accountRedirect);
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
