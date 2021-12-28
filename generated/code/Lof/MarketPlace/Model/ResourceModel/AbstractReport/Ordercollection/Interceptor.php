<?php
namespace Lof\MarketPlace\Model\ResourceModel\AbstractReport\Ordercollection;

/**
 * Interceptor class for @see \Lof\MarketPlace\Model\ResourceModel\AbstractReport\Ordercollection
 */
class Interceptor extends \Lof\MarketPlace\Model\ResourceModel\AbstractReport\Ordercollection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate, \Magento\Customer\Model\ResourceModel\Customer $customerResource, \Lof\MarketPlace\Helper\Data $helper, \Magento\Framework\Registry $registry)
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $objectManager, $scopeConfig, $storeManager, $localeDate, $customerResource, $helper, $registry);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurPage($displacement = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurPage');
        return $pluginInfo ? $this->___callPlugins('getCurPage', func_get_args(), $pluginInfo) : parent::getCurPage($displacement);
    }
}
