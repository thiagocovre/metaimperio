<?php
namespace Lof\MarketPlace\Controller\Marketplace\Order\Cancel;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Order\Cancel
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Order\Cancel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender, \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory, \Magento\Sales\Model\Order\Email\Sender\CreditmemoSender $creditmemoSender, \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository, \Magento\Sales\Model\Order\CreditmemoFactory $creditmemoFactory, \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Sales\Api\OrderManagementInterface $orderManagement, \Magento\Framework\Registry $coreRegistry, \Magento\Customer\Model\Session $customerSession, \Lof\MarketPlace\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $invoiceSender, $shipmentSender, $shipmentFactory, $creditmemoSender, $creditmemoRepository, $creditmemoFactory, $invoiceRepository, $stockConfiguration, $orderRepository, $orderManagement, $coreRegistry, $customerSession, $helper);
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
