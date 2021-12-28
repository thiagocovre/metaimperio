<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Saveimage;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Saveimage
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Saveimage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $initializationHelper, \Magento\Catalog\Model\Product\Copier $productCopier, \Magento\Catalog\Model\Product\TypeTransitionManager $productTypeManager, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Model\Seller $seller, \Magento\Catalog\Model\Product\Gallery\UpdateHandler $updateHandler, \Lof\MarketPlace\Helper\Data $helper, \Lof\MarketPlace\Helper\Uploadimage $uploadimage)
    {
        $this->___init();
        parent::__construct($context, $initializationHelper, $productCopier, $productTypeManager, $productRepository, $storeManager, $customerSession, $seller, $updateHandler, $helper, $uploadimage);
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
