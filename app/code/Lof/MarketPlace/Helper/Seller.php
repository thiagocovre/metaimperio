<?php
namespace Lof\MarketPlace\Helper;
use Lof\MarketPlace\Model\SellerFactory;
use Lof\MarketPlace\Model\SellerProductFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\App\Helper\Context;

class Seller  extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var SellerFactory
     */
    protected $sellerFactory;
    /**
     * @var SellerProductFactory
     */
    protected $sellerProductFactory;
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var \Lof\MarketPlace\Helper\Data
     */
    protected $_sellerHelper;
    public function __construct(Context $context,
                                SellerFactory $sellerFactory,
                                SellerProductFactory $sellerProductFactory,
                                CustomerFactory $customerFactory,
                                \Lof\MarketPlace\Helper\Data $sellerHelper,
                                \Magento\Customer\Model\Session $customerSession)
    {
        parent::__construct($context);
        $this->sellerFactory        = $sellerFactory;
        $this->sellerProductFactory = $sellerProductFactory;
        $this->customerFactory      = $customerFactory;
        $this->customerSession      = $customerSession;
        $this->_sellerHelper = $sellerHelper;
    }
    public function getSellerId() {

        $seller =   $this->sellerFactory->create()->load ( $this->getCustomerId(), 'customer_id' );

        return $seller->getData('seller_id');
    }
    public function getSellerIdByProduct($productId) {
        $seller = $this->sellerProductFactory->create()->load($productId, 'product_id');
        return $seller->getSellerId();
    }
    public function getSellerByProduct($productId) {
        $seller = $this->sellerProductFactory->create()->load($productId, 'product_id');
        return $seller;
    }
    public function getSellerByCustomer() {

        $seller =   $this->sellerFactory->create()->load ( $this->getCustomerId(), 'customer_id' );
        return $seller->getData();
    }
    public function getCustomerBySeller($sellerId) {

        $seller =   $this->sellerFactory->create()->load ( $sellerId, 'seller_id' );
        $customer = $this->customerFactory->create()->load($seller->getCustomerId());
        return $customer;
    }
    public function getCustomerId() {
        $customer = $this->customerSession->getCustomer();

        return $customer->getId();
    }
    public function checkCountry($country) {
        $availableCountries = $this->_sellerHelper->getConfig('available_countries/available_countries');
        $enableAvailableCountries = $this->_sellerHelper->getConfig('available_countries/enable_available_countries');
        if($enableAvailableCountries == '1' && $availableCountries) {
            $availableCountries = explode(',', $availableCountries);
            if(!in_array($country, $availableCountries)) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return true;
        }
    }
    public function checkSellerGroup($sellerGroup) {
        $enableSellerGroup = $this->_sellerHelper->getConfig('group_seller/enable_group_seller');
        $availableSellerGroup = $this->_sellerHelper->getConfig('group_seller/group_seller');
        if($enableSellerGroup == '1' && $availableSellerGroup) {
            $availableSellerGroup = explode(',', $availableSellerGroup);
            if(!in_array($sellerGroup, $availableSellerGroup)) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return true;
        }
    }
}