<?php
namespace Lof\MarketPlace\Controller\Marketplace\Product\Processimport;

/**
 * Interceptor class for @see \Lof\MarketPlace\Controller\Marketplace\Product\Processimport
 */
class Interceptor extends \Lof\MarketPlace\Controller\Marketplace\Product\Processimport implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\ImportExport\Model\Report\ReportProcessorInterface $reportProcessor, \Magento\ImportExport\Model\History $historyModel, \Magento\ImportExport\Helper\Report $reportHelper, \Magento\Framework\File\Csv $csvProcessor, \Magento\Catalog\Model\ProductFactory $productRepository, \Lof\MarketPlace\Helper\Data $helper, \Magento\Framework\App\ResourceConnection $resource, \Lof\MarketPlace\Model\SellerProduct $sellerproduct, \Magento\ImportExport\Model\Import $importModel)
    {
        $this->___init();
        parent::__construct($context, $reportProcessor, $historyModel, $reportHelper, $csvProcessor, $productRepository, $helper, $resource, $sellerproduct, $importModel);
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
