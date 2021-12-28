<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Save;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Save
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $initializationHelper, \Magento\Catalog\Model\Product\Copier $productCopier, \Magento\Catalog\Model\Product\TypeTransitionManager $productTypeManager, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Model\Seller $seller, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\ConfigurableProduct\Api\LinkManagementInterface $linkManagement, \Lof\MarketPlace\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $initializationHelper, $productCopier, $productTypeManager, $productRepository, $storeManager, $customerSession, $seller, $productFactory, $searchCriteriaBuilder, $linkManagement, $helper);
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
