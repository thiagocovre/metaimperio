<?php
namespace Lof\MarketPlace\Controller\Adminhtml\SellerProduct\Commission;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Adminhtml\SellerProduct\Commission
 */
class Interceptor extends \Lof\MarketPlace\Controller\Adminhtml\SellerProduct\Commission implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Lof\MarketPlace\Model\ResourceModel\SellerProduct\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $date, $dateTime, $storeManager, $productRepository, $collectionFactory);
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
