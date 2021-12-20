<?php

namespace Lof\MarketPlace\Api\Data;

interface SellerInterface  extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const SELLER_ID = 'seller_id';
    const CONTACT_NUMBER = 'contact_number';
    const SHOP_TITLE = 'shop_title';
    const COMPANY_LOCALITY = 'company_locality';
    const COMPANY_DESCRIPTION = 'company_description';
    const RETURN_POLICY = 'return_policy';
    const SHIPPING_POLICY = 'shipping_policy';
    const ADDRESS = 'address';
    const COUNTRY = 'country';
    const IMAGE = 'image';
    const THUMBNAIL = 'thumbnail';
    const CITY = 'city';
    const REGION = 'region';
	const GROUP = 'group';
    const URL = 'url';
    const CUSTOMER_ID = 'customer_id';
    const EMAIL = 'email';
    const NAME = 'name';
    const SALE = 'sale';
    const COMMISSION_ID = 'commission_id';
    const PAGE_LAYOUT = 'page_layout';
    const STTAUS = 'status';
    const POSITION = 'position';
    const TWITTER_ID = 'twitter_id';
    const FACEBOOK_ID = 'facebook_id';
    const GPLUS_ID = 'gplus_id';
    const YOUTUBE_ID = 'youtube_id';
    const VIMEO_ID = 'vimeo_id';
    const INSTAGRAM_ID = 'instagram_id';
    const PINTEREST_ID = 'pinterest_id';
    const LINKEDIN_ID = 'linkedin_id';
    const TW_ACTIVE = 'tw_active';
    const FB_ACTIVE = 'fb_active';
    const GPLUS_ACTIVE = 'gplus_active';
    const VIMEO_ACTIVE = 'vimeo_active';
    const INSTAGRAM_ACTIVE = 'instagram_active';
    const PINTEREST_ACTIVE = 'pinterest_active';
    const LINKEDIN_ACTIVE = 'linkedin_active';
    const BANNER_PIC = 'banner_pic';
    const SHOP_URL = 'shop_url';
    const LOGO_PIC = 'logo_pic';
    const STORE_ID = 'store_id';

    /**
     * Get sale
     * @return string|null
     */
    public function getSale();
    /**
     * Set sale
     * @param string $sale
     * @return string|null
     */
    public function setSale($sale);
    /**
     * Get commission_id
     * @return string|null
     */
    public function getCommissionId();
    /**
     * Set commission_id
     * @param string $commission_id
     * @return string|null
     */
    public function setCommissionId($commission_id);

    /**
     * Get page_layout
     * @return string|null
     */
    public function getPageLayout();
    /**
     * Set page_layout
     * @param string $page_layout
     * @return string|null
     */
    public function setPageLayout($page_layout);
    /**
     * Get status
     * @return string|null
     */
    public function getStatus();
    /**
     * Set status
     * @param string $status
     * @return string|null
     */
    public function setStatus($status);
    /**
     * Get position
     * @return string|null
     */
    public function getPosition();
    /**
     * Set position
     * @param string $position
     * @return string|null
     */
    public function setPosition($position);
    /**
     * Get twitter_id
     * @return string|null
     */
    public function getTwitterId();
    /**
     * Set twitter_id
     * @param string $twitter_id
     * @return string|null
     */
    public function setTwitterId($twitter_id);
    /**
     * Get facebook_id
     * @return string|null
     */
    public function getFacebookId();
    /**
     * Set facebook_id
     * @param string $facebook_id
     * @return string|null
     */
    public function setFacebookId($facebook_id);
    /**
     * Get gplus_id
     * @return string|null
     */
    public function getGplusId();
    /**
     * Set gplus_id
     * @param string $gplus_id
     * @return string|null
     */
    public function setGplusId($gplus_id);
    /**
     * Get youtube_id
     * @return string|null
     */
    public function getYoutubeId();
    /**
     * Set youtube_id
     * @param string $youtube_id
     * @return string|null
     */
    public function setYoutubeId($youtube_id);
    /**
     * Get vimeo_id
     * @return string|null
     */
    public function getVimeoId();
    /**
     * Set vimeo_id
     * @param string $vimeo_id
     * @return string|null
     */
    public function setVimeoId($vimeo_id);
    /**
     * Get instagram_id
     * @return string|null
     */
    public function getInstagramId();
    /**
     * Set instagram_id
     * @param string $instagram_id
     * @return string|null
     */
    public function setInstagramId($instagram_id);
    /**
     * Get pinterest_id
     * @return string|null
     */
    public function getPinterestId();
    /**
     * Set pinterest_id
     * @param string $pinterest_id
     * @return string|null
     */
    public function setPinterestId($pinterest_id);
    /**
     * Get linkedin_id
     * @return string|null
     */
    public function getLinkedinId();
    /**
     * Set linkedin_id
     * @param string $linkedin_id
     * @return string|null
     */
    public function setLinkedinId($linkedin_id);
    /**
     * Get tw_active
     * @return string|null
     */
    public function getTwActive();
    /**
     * Set tw_active
     * @param string $tw_active
     * @return string|null
     */
    public function setTwActive($tw_active);
    /**
     * Get fb_active
     * @return string|null
     */
    public function getFbActive();
    /**
     * Set fb_active
     * @param string $fb_active
     * @return string|null
     */
    public function setFbActive($fb_active);
    /**
     * Get gplus_active
     * @return string|null
     */
    public function getGplusActive();
    /**
     * Set gplus_active
     * @param string $gplus_active
     * @return string|null
     */
    public function setGplusActive($gplus_active);
    /**
     * Get vimeo_active
     * @return string|null
     */
    public function getVimeoActive();
    /**
     * Set vimeo_active
     * @param string $vimeo_active
     * @return string|null
     */
    public function setVimeoActive($vimeo_active);
    /**
     * Get instagram_active
     * @return string|null
     */
    public function getInstagramActive();
    /**
     * Set instagram_active
     * @param string $instagram_active
     * @return string|null
     */
    public function setInstagramActive($instagram_active);
    /**
     * Get pinterest_active
     * @return string|null
     */
    public function getPinterestActive();
    /**
     * Set pinterest_active
     * @param string $pinterest_active
     * @return string|null
     */
    public function setPinterestActive($pinterest_active);
    /**
     * Get linkedin_active
     * @return string|null
     */
    public function getLinkedinActive();
    /**
     * Set linkedin_active
     * @param string $linkedin_active
     * @return string|null
     */
    public function setLinkedinActive($linkedin_active);
    /**
     * Get banner_pic
     * @return string|null
     */
    public function getBannerPic();
    /**
     * Set banner_pic
     * @param string $banner_pic
     * @return string|null
     */
    public function setBannerPic($banner_pic);
   /**
     * Get shop_url
     * @return string|null
     */
    public function getShopUrl();
    /**
     * Set shop_url
     * @param string $shop_url
     * @return string|null
     */
    public function setShopUrl($shop_url);
   /**
     * Get logo_pic
     * @return string|null
     */
    public function getLogoPic();
    /**
     * Set logo_pic
     * @param string $logo_pic
     * @return string|null
     */
    public function setLogoPic($logo_pic);
   /**
     * Get store_id
     * @return string|null
     */
    public function getStoreId();
    /**
     * Set store_id
     * @param string $store_id
     * @return string|null
     */
    public function setStoreId($store_id);
    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();
    /**
     * Set seller_id
     * @param string $seller_id
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     */
    public function setSellerId($sellerId);

    /**
     * get contact_number
     * @return string|null
     */
    public function getContactNumber();
    /**
     * Set contact_number
     * @param string $contact_number
     * @return string|null
     */
    public function setContactNumber($contact_number);
    /**
     * get customer_id
     * @param string $customer_id
     * @return string|null
     */
    public function getCustomerId();
    /**
     * Set customer_id
     * @param string $customer_id
     * @return string|null
     */
    public function setCustomerId($customer_id);
    /**
     * get name
     * @param string $name
     * @return string|null
     */
    public function getName();
    /**
     * Set name
     * @param string $name
     * @return string|null
     */
    public function setName($name);
    /**
     * get email
     * @param string $email
     * @return string|null
     */
    public function getEmail();
    /**
     * Set email
     * @param string $email
     * @return string|null
     */
    public function setEmail($email);

    /**
     * get shop_title
     * @return string|null
     */
    public function getShopTitle();

    /**
     * Set shop_title
     * @param string $shop_title
     * @return string|null
     */
    public function setShopTitle($shop_title);

    /**
     * get company_locality
     * @return string|null
     */
    public function getCompanyLocality();

    /**
     * Set company_locality
     * @param string $company_locality
     * @return string|null
     */
    public function setCompanyLocality($company_locality);

    /**
     * get company_description
     * @return string|null
     */
    public function getCompanyDescription();

    /**
     * Set company_description
     * @param string $company_description
     * @return string|null
     */
    public function setCompanyDescription($company_description);

    /**
     * get return_policy
     * @return string|null
     */
    public function getReturnPolicy();

    /**
     * Set return_policy
     * @param string $return_policy
     * @return string|null
     */
    public function setReturnPolicy($return_policy);

    /**
     * get shipping_policy
     * @return string|null
     */
    public function getShippingPolicy();

    /**
     * Set shipping_policy
     * @param string $shipping_policy
     * @return string|null
     */
    public function setShippingPolicy($shipping_policy);

    /**
     * get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return string|null
     */
    public function setAddress($address);

    /**
     * get country
     * @return string|null
     */
    public function getCountry();

    /**
     * Set Country
     * @param string $country
     * @return string|null
     */
    public function setCountry($country);

    /**
     * get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return string|null
     */
    public function setImage($image);

    /**
     * get thumbnail
     * @return string|null
     */
    public function getThumbnail();

    /**
     * Set thumbnail
     * @param string $thumbnail
     * @return string|null
     */
    public function setThumbnail($thumbnail);

    /**
     * get region
     * @return string|null
     */
    public function getRegion();

    /**
     * Set region
     * @param string $region
     * @return string|null
     */
    public function setRegion($region);

    /**
     * get city
     * @return string|null
     */
    public function getCity();

    /**
     * Set city
     * @param string $city
     * @return string|null
     */
    public function setCity($city);

    /**
     * get group
     * @return string|null
     */
    public function getGroup();
    /**
     * Set group
     * @param string $group
     * @return string|null
     */
    public function setGroup($group);

    /**
     * get url
     * @return string|null
     */
    public function getUrl();

    /**
     * Set Url
     * @param string $url
     * @return string|null
     */
    public function setUrl($url);
}
