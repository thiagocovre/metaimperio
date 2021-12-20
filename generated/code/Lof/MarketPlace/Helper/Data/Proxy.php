<?php
namespace Lof\MarketPlace\Helper\Data;

/**
 * Proxy class for @see \Lof\MarketPlace\Helper\Data
 */
class Proxy extends \Lof\MarketPlace\Helper\Data implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Lof\MarketPlace\Helper\Data
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Lof\\MarketPlace\\Helper\\Data', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        $this->_subject = clone $this->_getSubject();
    }

    /**
     * Get proxied instance
     *
     * @return \Lof\MarketPlace\Helper\Data
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function uploadZip($strtotime)
    {
        return $this->_getSubject()->uploadZip($strtotime);
    }

    /**
     * {@inheritdoc}
     */
    public function flushFilesCache($path, $removeParent = false)
    {
        return $this->_getSubject()->flushFilesCache($path, $removeParent);
    }

    /**
     * {@inheritdoc}
     */
    public function removeDir($dir)
    {
        return $this->_getSubject()->removeDir($dir);
    }

    /**
     * {@inheritdoc}
     */
    public function flushData($profileId)
    {
        return $this->_getSubject()->flushData($profileId);
    }

    /**
     * {@inheritdoc}
     */
    public function getBasePath($profileId)
    {
        return $this->_getSubject()->getBasePath($profileId);
    }

    /**
     * {@inheritdoc}
     */
    public function getMediaPath()
    {
        return $this->_getSubject()->getMediaPath();
    }

    /**
     * {@inheritdoc}
     */
    public function arrangeFiles($path, $originalPath = '', $result = [])
    {
        return $this->_getSubject()->arrangeFiles($path, $originalPath, $result);
    }

    /**
     * {@inheritdoc}
     */
    public function getFrontendUrl($route = '', $params = [])
    {
        return $this->_getSubject()->getFrontendUrl($route, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryname($countryCode)
    {
        return $this->_getSubject()->getCountryname($countryCode);
    }

    /**
     * {@inheritdoc}
     */
    public function isEnableModule($module)
    {
        return $this->_getSubject()->isEnableModule($module);
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCurrencyCode()
    {
        return $this->_getSubject()->getCurrentCurrencyCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCurrencySymbol()
    {
        return $this->_getSubject()->getCurrentCurrencySymbol();
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceFomat($price, $currencyCode = '')
    {
        return $this->_getSubject()->getPriceFomat($price, $currencyCode);
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupList()
    {
        return $this->_getSubject()->getGroupList();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerOfSeller()
    {
        return $this->_getSubject()->getCustomerOfSeller();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerList($customer_id = null)
    {
        return $this->_getSubject()->getCustomerList($customer_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommissionList()
    {
        return $this->_getSubject()->getCommissionList();
    }

    /**
     * {@inheritdoc}
     */
    public function getCommission($sellerId, $productId)
    {
        return $this->_getSubject()->getCommission($sellerId, $productId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerId()
    {
        return $this->_getSubject()->getSellerId();
    }

    /**
     * {@inheritdoc}
     */
    public function getStore()
    {
        return $this->_getSubject()->getStore();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStoreId()
    {
        return $this->_getSubject()->getCurrentStoreId();
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteId()
    {
        return $this->_getSubject()->getWebsiteId();
    }

    /**
     * {@inheritdoc}
     */
    public function getProductTypeRestriction()
    {
        return $this->_getSubject()->getProductTypeRestriction();
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeSetRestriction()
    {
        return $this->_getSubject()->getAttributeSetRestriction();
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlShortcut()
    {
        return $this->_getSubject()->getUrlShortcut();
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig($key, $store = null)
    {
        return $this->_getSubject()->getConfig($key, $store);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreConfig($key, $store = null)
    {
        return $this->_getSubject()->getStoreConfig($key, $store);
    }

    /**
     * {@inheritdoc}
     */
    public function filter($str)
    {
        return $this->_getSubject()->filter($str);
    }

    /**
     * {@inheritdoc}
     */
    public function isLoggedIn()
    {
        return $this->_getSubject()->isLoggedIn();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerName()
    {
        return $this->_getSubject()->getCustomerName();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerEmail()
    {
        return $this->_getSubject()->getCustomerEmail();
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId()
    {
        return $this->_getSubject()->getCustomerId();
    }

    /**
     * {@inheritdoc}
     */
    public function nicetime($timestamp, $detailLevel = 1)
    {
        return $this->_getSubject()->nicetime($timestamp, $detailLevel);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatDate($date, $type = 'full')
    {
        return $this->_getSubject()->getFormatDate($date, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function formatDate($date = null, $format = 3, $showTime = false, $timezone = null)
    {
        return $this->_getSubject()->formatDate($date, $format, $showTime, $timezone);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus($id)
    {
        return $this->_getSubject()->getStatus($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusRating($id)
    {
        return $this->_getSubject()->getStatusRating($id);
    }

    /**
     * {@inheritdoc}
     */
    public function arrayStatusRating()
    {
        return $this->_getSubject()->arrayStatusRating();
    }

    /**
     * {@inheritdoc}
     */
    public function statusRating()
    {
        return $this->_getSubject()->statusRating();
    }

    /**
     * {@inheritdoc}
     */
    public function arrayStatus()
    {
        return $this->_getSubject()->arrayStatus();
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct()
    {
        return $this->_getSubject()->getProduct();
    }

    /**
     * {@inheritdoc}
     */
    public function getProductById($product_id)
    {
        return $this->_getSubject()->getProductById($product_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerById($customer_id)
    {
        return $this->_getSubject()->getCustomerById($customer_id);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerByEmail($customer_email)
    {
        return $this->_getSubject()->getCustomerByEmail($customer_email);
    }

    /**
     * {@inheritdoc}
     */
    public function getAreaFrontName($checkHost = false)
    {
        return $this->_getSubject()->getAreaFrontName($checkHost);
    }

    /**
     * {@inheritdoc}
     */
    public function getMediaUrl()
    {
        return $this->_getSubject()->getMediaUrl();
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentUrls()
    {
        return $this->_getSubject()->getCurrentUrls();
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->_getSubject()->getStoreId();
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreCode()
    {
        return $this->_getSubject()->getStoreCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreName()
    {
        return $this->_getSubject()->getStoreName();
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreUrl($fromStore = true)
    {
        return $this->_getSubject()->getStoreUrl($fromStore);
    }

    /**
     * {@inheritdoc}
     */
    public function isStoreActive()
    {
        return $this->_getSubject()->isStoreActive();
    }

    /**
     * {@inheritdoc}
     */
    public function getModulesUseTemplateFromAdminhtml()
    {
        return $this->_getSubject()->getModulesUseTemplateFromAdminhtml();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlocksUseTemplateFromAdminhtml()
    {
        return $this->_getSubject()->getBlocksUseTemplateFromAdminhtml();
    }

    /**
     * {@inheritdoc}
     */
    public function getTableKey($key)
    {
        return $this->_getSubject()->getTableKey($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderinfo($id)
    {
        return $this->_getSubject()->getOrderinfo($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getTracking($orderId)
    {
        return $this->_getSubject()->getTracking($orderId);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelorder($order, $sellerId)
    {
        return $this->_getSubject()->cancelorder($order, $sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function mpregisterCancellation($order, $sellerId, $comment = '')
    {
        return $this->_getSubject()->mpregisterCancellation($order, $sellerId, $comment);
    }

    /**
     * {@inheritdoc}
     */
    public function checkAuth($flag = true)
    {
        return $this->_getSubject()->checkAuth($flag);
    }

    /**
     * {@inheritdoc}
     */
    public function getAPISellerID($seller_data = '')
    {
        return $this->_getSubject()->getAPISellerID($seller_data);
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        return $this->_getSubject()->isModuleOutputEnabled($moduleName);
    }
}
