<?php
namespace Amasty\Gdpr\Model\Consent\ConsentStore\ResourceModel;

/**
 * Factory class for @see \Amasty\Gdpr\Model\Consent\ConsentStore\ResourceModel\ConsentStoreCollection
 */
class ConsentStoreCollectionFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Amasty\\Gdpr\\Model\\Consent\\ConsentStore\\ResourceModel\\ConsentStoreCollection')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Amasty\Gdpr\Model\Consent\ConsentStore\ResourceModel\ConsentStoreCollection
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
