<?php
namespace Magento\Customer\Model\Address\AbstractAddress;

/**
 * Interceptor class for @see \Magento\Customer\Model\Address\AbstractAddress
 */
class Interceptor extends \Magento\Customer\Model\Address\AbstractAddress implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory, \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory, \Magento\Directory\Helper\Data $directoryData, \Magento\Eav\Model\Config $eavConfig, \Magento\Customer\Model\Address\Config $addressConfig, \Magento\Directory\Model\RegionFactory $regionFactory, \Magento\Directory\Model\CountryFactory $countryFactory, \Magento\Customer\Api\AddressMetadataInterface $metadataService, \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory, \Magento\Customer\Api\Data\RegionInterfaceFactory $regionDataFactory, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, ?\Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, ?\Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = [], ?\Magento\Customer\Model\Address\CompositeValidator $compositeValidator = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $directoryData, $eavConfig, $addressConfig, $regionFactory, $countryFactory, $metadataService, $addressDataFactory, $regionDataFactory, $dataObjectHelper, $resource, $resourceCollection, $data, $compositeValidator);
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validate');
        return $pluginInfo ? $this->___callPlugins('validate', func_get_args(), $pluginInfo) : parent::validate();
    }
}
