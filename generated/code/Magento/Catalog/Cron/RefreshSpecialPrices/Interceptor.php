<?php
namespace Magento\Catalog\Cron\RefreshSpecialPrices;

/**
 * Interceptor class for @see \Magento\Catalog\Cron\RefreshSpecialPrices
 */
class Interceptor extends \Magento\Catalog\Cron\RefreshSpecialPrices implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\ResourceConnection $resource, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Eav\Model\Config $eavConfig, \Magento\Catalog\Model\Indexer\Product\Price\Processor $processor)
    {
        $this->___init();
        parent::__construct($storeManager, $resource, $dateTime, $localeDate, $eavConfig, $processor);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }
}
