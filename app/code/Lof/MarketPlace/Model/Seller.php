<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2014 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\MarketPlace\Model;

use Lof\MarketPlace\Helper\Data;
use Lof\MarketPlace\Model\ResourceModel\Seller\Collection;
use Lof\MarketPlace\Model\SellerFactory;
use Magento\Authorization\Model\CompositeUserContext;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\DataObject\IdentityInterface;
use Lof\MarketPlace\Api\SellersRepositoryInterface;
use Lof\MarketPlace\Api\Data\SellerInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Seller Model
 */
class Seller extends \Magento\Framework\Model\AbstractModel implements SellersRepositoryInterface
{
    /**
     * Seller's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const STATUS_VERIFY = 1;
    const STATUS_UNVERIFY = 0;

    /**
     * Product collection factory
     *
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /** @var StoreManagerInterface */
    protected $_storeManager;

    /**
     * URL Model instance
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $_sellerHelper;

    protected $customer;

    protected $datasellerFactory;
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var AddressFactory
     */
    protected $addressFactory;
    /**
     * @var CompositeUserContext
     */
    protected $userContext;
    /**
     * @var SellerFactory
     */
    protected $sellerFactory;
    /**
     * @var \Lof\MarketPlace\Model\Sender
     */
    protected $sender;
    /**
     * @var \Lof\MarketPlace\Helper\Seller
     */
    protected $heplerSeller;
    /**
     * @var AccountManagementInterface
     */
    protected $accountManagement;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param ResourceModel\Seller|null $resource
     * @param Collection|null $resourceCollection
     * @param \Lof\MarketPlace\Model\SellerFactory $sellerFactory
     * @param CollectionFactory $productCollectionFactory
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\UrlInterface $url
     * @param Data $sellerHelper
     * @param \Magento\Customer\Model\Session $customer
     * @param SellerInterfaceFactory $datasellerFactory
     * @param Sender $sender
     * @param CustomerFactory $customerFactory
     * @param AddressFactory $addressFactory
     * @param AccountManagementInterface $accountManagement
     * @param CompositeUserContext $userContext
     * @param \Lof\MarketPlace\Helper\Seller $heplerSeller
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ResourceModel\Seller $resource = null,
        Collection $resourceCollection = null,
        SellerFactory $sellerFactory,
        CollectionFactory $productCollectionFactory,
        StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $url,
        Data $sellerHelper,
        \Magento\Customer\Model\Session $customer,
        SellerInterfaceFactory $datasellerFactory,
        \Lof\MarketPlace\Model\Sender $sender,
        CustomerFactory $customerFactory,
        AddressFactory $addressFactory,
        AccountManagementInterface $accountManagement,
        CompositeUserContext $userContext,
        \Lof\MarketPlace\Helper\Seller $heplerSeller,
        array $data = []
    ) {
        $this->_storeManager              = $storeManager;
        $this->_url                       = $url;
        $this->_productCollectionFactory  = $productCollectionFactory;
        $this->_sellerHelper              = $sellerHelper;
        $this->customer                   = $customer;
        $this->customerFactory            = $customerFactory;
        $this->addressFactory             = $addressFactory;
        $this->datasellerFactory          = $datasellerFactory;
        $this->sender                     = $sender;
        $this->userContext                = $userContext;
        $this->sellerFactory              = $sellerFactory;
        $this->heplerSeller              = $heplerSeller;
        $this->accountManagement              = $accountManagement;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize customer model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Lof\MarketPlace\Model\ResourceModel\Seller');
    }

    /**
     * Prepare page's statuses.
     * Available event cms_page_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Approved'), self::STATUS_DISABLED => __('Disapproved')];
    }
    public function getAvailableVerifyStatuses()
    {
        return [self::STATUS_VERIFY => __('Yes'), self::STATUS_UNVERIFY => __('No')];
    }

    /**
     * Check if page identifier exist for specific store
     * return page id if page exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }

    /**
     * Get category products collection
     *
     * @return \Magento\Framework\Data\Collection\AbstractDb
     */
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create()->addAttributeToSelect('*');

        $data = array();
        foreach ($collection as $key => $_collection) {
            if ($_collection->getSellerId() == $this->getSellerId()) {
                $data[] = $_collection->getData()['entity_id'];
            }
        }
        return $data;
    }

    public function getSellerId()
    {
        $collection = $this->getCollection()->addFieldToFilter('seller_id', $this->customer->getCustomerId());
        $seller_id = -1;

        foreach ($collection as $key => $_collection) {
            $seller_id = $_collection->getData('seller_id');
        }
        return $seller_id;
    }


    public function loadByCustomer(\Magento\Customer\Model\Customer $customer)
    {
        $this->_getResource()->loadByCustomer($this, $customer);
        return $this;
    }

    public function getUrl()
    {
        $url = $this->_storeManager->getStore()->getBaseUrl();
        $route = $this->_sellerHelper->getConfig('general_settings/route');
        $url_prefix = $this->_sellerHelper->getConfig('general_settings/url_prefix');
        $urlPrefix = '';
        if ($url_prefix) {
            $urlPrefix = $url_prefix.'/';
        }
        $url_suffix = $this->_sellerHelper->getConfig('general_settings/url_suffix');
        return $url.$urlPrefix.$this->getUrlKey().$url_suffix;
    }

    /**
     * Retrive image URL
     *
     * @return string
     */
    public function getImageUrl()
    {
        $url = false;
        $image = $this->getImage();
        if ($image) {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . $image;
        };
        return $url;
    }

    /**
     * Retrive thumbnail URL
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        $url = false;
        $thumbnail = $this->getThumbnail();
        if ($thumbnail) {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) . $thumbnail;
        } else {
            $url = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
            ) .'images/user.png';
        }
        return $url;
    }
    // ------------- API
    public function getAPISellerID($data)//get seller data from api
    {
        $seller_id = null;
        $data = json_decode($data);
        $seller = $this->getCollection()->addFieldToFilter('seller_id', $data->id)->getFirstItem();
        if ($seller) {
            $seller_data = $seller->getData();
            $seller_id = (int)$seller_data["seller_id"];
        }
        return $seller_id;
    }
    /**
     * Get seller by Customer ID.
     * @param int $customerId
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentSellers($customerId)
    {
        $result = [
            "code" => 405,
            "message" => "Error",
            "result" => []
        ];
        if ($customerId) {
            $seller = $this->getCollection()->addFieldToFilter('customer_id', $customerId)->getFirstItem();
            $seller_data = $seller->getData();
            if (count($seller_data)>0) {
                $res = [
                    "seller_id" => (int)$seller_data["seller_id"],
                    "contact_number"=> $seller_data["contact_number"],
                    "shop_title"=> $seller_data["shop_title"],
                    "company_locality"=> $seller_data["company_locality"],
                    "company_description"=> $seller_data["company_description"],
                    "return_policy"=> $seller_data["return_policy"],
                    "shipping_policy"=> $seller_data["shipping_policy"],
                    "address"=> $seller_data["address"],
                    "country"=> $seller_data["country"],
                    "image"=> $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $seller_data["image"],
                    "thumbnail"=> $this->_storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $seller_data["thumbnail"]
                ];
            } else {
                throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
            }
            $result["code"] = 0;
            $result["message"] = "get message success";
            $result["result"]["me"] = $res;
        }
        return $result;
    }
    /**
     * Save profile Seller
     * @param \Lof\MarketPlace\Api\Data\SellerInterface $seller
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function saveProfile(\Lof\MarketPlace\Api\Data\SellerInterface $seller)
    {
        try {
            if ($seller->getSellerId()) {
                $result = [
                    "code" => 405,
                    "message" => "Error"
                ];
                $seller_id = $seller->getSellerId();
                $seller_model = $this->load($seller_id);
                if ($seller_model) {
                    $data["seller_id"] = $seller_id;
                    $data["contact_number"] = $seller->getContactNumber();
                    $data["shop_title"] = $seller->getShopTitle();
                    $data["company_locality"] = $seller->getCompanyLocality();
                    $data["company_description"] = $seller->getCompanyDescription();
                    $data["return_policy"] = $seller->getReturnPolicy();
                    $data["shipping_policy"] = $seller->getShippingPolicy();
                    $data["address"] = $seller->getAddress();
                    $data["country"] = $seller->getCountry();
                    $data["image"] = $seller->getImage();
                    $data["thumbnail"] = $seller->getThumbnail();
                    $data["city"] = $seller->getCity();
                    $data["email"] = $seller->getEmail();
                    $data["name"] = $seller->getName();
                    $data["twitter_id"] = $seller->getTwitterId();
                    $data["facebook_id"] = $seller->getFacebookId();
                    $data["youtube_id"] = $seller->getYoutubeId();
                    $data["gplus_id"] = $seller->getGplusId();
                    $data["vimeo_id"] = $seller->getVimeoId();
                    $data["instagram_id"] = $seller->getInstagramId();
                    $data["pinterest_id"] = $seller->getPinterestId();
                    $data["linkedin_id"] = $seller->getLinkedinId();
                    $data["tw_active"] = $seller->getTwActive();
                    $data["fb_active"] = $seller->getFbActive();
                    $data["gplus_active"] = $seller->getGplusActive();
                    $data["vimeo_active"] = $seller->getVimeoActive();
                    $data["instagram_active"] = $seller->getInstagramActive();
                    $data["pinterest_active"] = $seller->getPinterestActive();
                    $data["linkedin_active"] = $seller->getLinkedinActive();
                    $data["banner_pic"] = $seller->getBannerPic();
                    $data["shop_url"] = $seller->getShopUrl();
                    $data["logo_pic"] = $seller->getLogoPic();
                    $data["store_id"] = $seller->getStoreId();
                    $seller_model->setData($data);
                    $seller_model->save();
                    $result = [
                            "code" => 0,
                            "message" => "Update data success!"
                        ];
                }
            } else {
                throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
            }
        } catch (\Exception $exception) {
            throw new Exception(__(
                'Could not save the seller info: %1'
            ));
        }
        return $result;
    }

    /**
     * create Seller by customer
     * @param \Lof\MarketPlace\Api\Data\SellerInterface $seller
     * @param int $customerId
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function saveSeller(\Lof\MarketPlace\Api\Data\SellerInterface $seller, $customerId)
    {
        $res = Config::RES_RESULT;
        if ($seller) {
            $group          = $seller->getGroup();
            $region         = $seller->getRegion();
            $city           = $seller->getCity();
            $address        = $seller->getAddress();
            $country        = $seller->getCountry();
            $image          = $seller->getImage();
            $shopTile       = $seller->getShopTitle();
            $thumnail       = $seller->getThumbnail();
            $telephone      = $seller->getContactNumber();
            $company        = $seller->getCompanyLocality();
            $name           = $seller->getName();
            $email          = $seller->getEmail();
            $url            = $seller->getUrl();
            $sellerApproval = $this->_sellerHelper->getConfig('general_settings/seller_approval');
            $availableCountries = $this->_sellerHelper->getConfig('available_countries/available_countries');
            $enableAvailableCountries = $this->_sellerHelper->getConfig('available_countries/enable_available_countries');
            $enableSellerGroup = $this->_sellerHelper->getConfig('group_seller/enable_group_seller');
            $availableSellerGroup = $this->_sellerHelper->getConfig('group_seller/group_seller');
            $layout         = "2columns-left";
            $stores         = array();
            $stores[]       = $this->_sellerHelper->getCurrentStoreId();
            $sellerFactory  = $this->sellerFactory->create();
            $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
            $sellerModel    = $objectManager->get('Lof\MarketPlace\Model\Seller');
            $status         = ($sellerApproval)? 0 : 1;
            try {
                if (!$status) {
                    $sellerModel->setName($name)
                            ->setEmail($email)
                            ->setStatus($status)
                            ->setGroupId($group)
                            ->setCustomerId($customerId)
                            ->setStores($stores)
                            ->setReagion($region)
                            ->setCity($city)
                            ->setAddress($address)
                            ->setCountry($country)
                            ->setImage($image)
                            ->setShopTitle($shopTile)
                            ->setThumbnail($thumnail)
                            ->setContactNumber($telephone)
                            ->setTelephone($telephone)
                            ->setCompany($company)
                            ->setUrlKey($url)
                            ->setPageLayout($layout);
                    if ($sellerApproval) {
                        $res = [
                                "code" => 0,
                                "message" => "Save data success! Please wait admin approval"
                            ];
                    } else {
                        $res = [
                                "code" => 0,
                                "message" => "Save data success!"
                            ];
                    }
                    if (!$this->heplerSeller->checkCountry($country)) {
                        $res = [
                                "message" => "Sorry. The store does not support to create sellers in your country"
                            ];
                    }
                    if (!$this->heplerSeller->checkSellerGroup($group)) {
                        $res = [
                                "message" => "Sorry. The store does not support to create sellers in your seller group"
                            ];
                    } else {
                        $sellerModel->save();
                    }
                } else {
                    $res = [
                                "code" => 0,
                                "message" => "You are really seller"
                            ];
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                throw new \Exception($e->getMessage());
            }
            if ($this->_sellerHelper->getConfig('email_settings/enable_send_email')) {
                $data = [];
                $data['name'] = $name;
                $data['email'] = $email;
                $data['group'] = $group;
                $data['url'] = $sellerModel->getUrl();
                $objectManager->create("Lof\MarketPlace\Model\Sender")->registerSeller($data);
            }
        }
        header('Content-Type: application/json');
        return $res;
    }
    /**
     * create new seller
     * @param \Magento\Customer\Api\Data\CustomerInterface $seller
     * @param  mixed $data
     * @param  string $password
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function registerNewSeller(\Magento\Customer\Api\Data\CustomerInterface $customer, $data, $password = null)
    {
        $newCustomer = $this->accountManagement->createAccount($customer, $password);
        $addressCustomer = $this->addressFactory->create()->load($newCustomer->getId());
        $customerId = $newCustomer->getId();
        $res = Config::RES_RESULT;
        if ($customer) {
            $group          = $data['group'];
            $region         = $addressCustomer->getRegion();
            $city           = $addressCustomer->getCity();
            $address        = $addressCustomer->getStreet();
            $country        = $addressCustomer->getCountry();
            $telephone      = $addressCustomer->getTelephone();
            $company        = $addressCustomer->getCompany();
            $name           = $addressCustomer->getName();
            $email          = $newCustomer->getEmail();
            $url            = $data['url_key'];
            $sellerApproval = $this->_sellerHelper->getConfig('general_settings/seller_approval');
            $availableCountries = $this->_sellerHelper->getConfig('available_countries/available_countries');
            $enableAvailableCountries = $this->_sellerHelper->getConfig('available_countries/enable_available_countries');
            $enableSellerGroup = $this->_sellerHelper->getConfig('group_seller/enable_group_seller');
            $availableSellerGroup = $this->_sellerHelper->getConfig('group_seller/group_seller');
            $layout         = "2columns-left";
            $stores         = array();
            $stores[]       = $this->_sellerHelper->getCurrentStoreId();
            $sellerFactory  = $this->sellerFactory->create();
            $objectManager  = \Magento\Framework\App\ObjectManager::getInstance();
            $sellerModel    = $objectManager->get('Lof\MarketPlace\Model\Seller');
            $status         = ($sellerApproval)? 0 : 1;
            try {
                if (!$status) {
                    $sellerModel->setData($addressCustomer->getData())
                        ->setUrlKey($url)->setGroupId($group)
                        ->setName($newCustomer->getFirstname().' '. $newCustomer->getLastname())
                        ->setCountry($addressCustomer->getCountryId());
                    if ($sellerApproval) {
                        $res = [
                            "code" => 0,
                            "message" => "Save data success! Please wait admin approval"
                        ];
                    } else {
                        $res = [
                            "code" => 0,
                            "message" => "Save data success!"
                        ];
                    }
                    if (!$this->heplerSeller->checkCountry($country)) {
                        $res = [
                            "message" => "Sorry. The store does not support to create sellers in your country"
                        ];
                    }
                    if (!$this->heplerSeller->checkSellerGroup($group)) {
                        $res = [
                            "message" => "Sorry. The store does not support to create sellers in your seller group"
                        ];
                    } else {
                        $sellerModel->save();
                    }
                } else {
                    $res = [
                        "code" => 0,
                        "message" => "You are really seller"
                    ];
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                throw new \Exception($e->getMessage());
            }
            if ($this->_sellerHelper->getConfig('email_settings/enable_send_email')) {
                $data = [];
                $data['name'] = $name;
                $data['email'] = $email;
                $data['group'] = $group;
                $data['url'] = $sellerModel->getUrl();
                $objectManager->create("Lof\MarketPlace\Model\Sender")->registerSeller($data);
            }
        }
        header('Content-Type: application/json');
        return $res;
    }
}
