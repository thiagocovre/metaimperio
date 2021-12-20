<?php
namespace Magento\Directory\Model\ResourceModel\Country;

/**
 * Interceptor class for @see \Magento\Directory\Model\ResourceModel\Country
 */
class Interceptor extends \Magento\Directory\Model\ResourceModel\Country implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context, ?string $connectionName = null, ?\Magento\Framework\Escaper $escaper = null)
    {
        $this->___init();
        parent::__construct($context, $connectionName, $escaper);
    }

    /**
     * {@inheritdoc}
     */
    public function loadByCode(\Magento\Directory\Model\Country $country, $code)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'loadByCode');
        return $pluginInfo ? $this->___callPlugins('loadByCode', func_get_args(), $pluginInfo) : parent::loadByCode($country, $code);
    }
}
