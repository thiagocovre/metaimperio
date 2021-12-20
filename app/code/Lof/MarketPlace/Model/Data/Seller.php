<?php

namespace Lof\MarketPlace\Model\Data;

// use Lof\CouponCode\Api\Data\ConditionInterface;
use Lof\MarketPlace\Api\Data\SellerInterface;

/**
 * Class Rule
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @codeCoverageIgnore
 */
class Seller extends \Magento\Framework\Api\AbstractExtensibleObject implements SellerInterface
{
    const KEY_SELLER_ID = 'seller_id';
    const KEY_CONTACT_NUMBER = 'contact_number';
    const KEY_SHOP_TITLE = 'shop_title';
    const KEY_COMPANY_LOCALITY = 'company_locality';
    const KEY_COMPANY_DESCRIPTION = 'company_description';
    const KEY_RETURN_POLICY = 'return_policy';
    const KEY_SHIPPING_POLICY = 'shipping_policy';
    const KEY_ADDRESS = 'address';
    const KEY_COUNTRY = 'country';
    const KEY_IMAGE = 'image';
    const KEY_THUMBNAIL = 'thumbnail';
    const KEY_CITY = 'city';
    const KEY_REGION = 'region';
	const KEY_GROUP = 'group';
    const KEY_URL = 'url';
    const KEY_CUSTOMER_ID = 'customer_id';
    const KEY_EMAIL = 'email';
    const KEY_NAME = 'name';
    const KEY_SALE = 'sale';
    const KEY_COMMISSION_ID = 'commission_id';
    const KEY_PAGE_LAYOUT = 'page_layout';
    const KEY_STTAUS = 'status';
    const KEY_POSITION = 'position';
    const KEY_TWITTER_ID = 'twitter_id';
    const KEY_FACEBOOK_ID = 'facebook_id';
    const KEY_GPLUS_ID = 'gplus_id';
    const KEY_YOUTUBE_ID = 'youtube_id';
    const KEY_VIMEO_ID = 'vimeo_id';
    const KEY_INSTAGRAM_ID = 'instagram_id';
    const KEY_PINTEREST_ID = 'pinterest_id';
    const KEY_LINKEDIN_ID = 'linkedin_id';
    const KEY_TW_ACTIVE = 'tw_active';
    const KEY_FB_ACTIVE = 'fb_active';
    const KEY_GPLUS_ACTIVE = 'gplus_active';
    const KEY_VIMEO_ACTIVE = 'vimeo_active';
    const KEY_INSTAGRAM_ACTIVE = 'instagram_active';
    const KEY_PINTEREST_ACTIVE = 'pinterest_active';
    const KEY_LINKEDIN_ACTIVE = 'linkedin_active';
    const KEY_BANNER_PIC = 'banner_pic';
    const KEY_SHOP_URL = 'shop_url';
    const KEY_LOGO_PIC = 'logo_pic';
    const KEY_STORE_ID = 'store_id';
    public function getStatus()
    {
        return $this->_get(self::KEY_SALE);
    }
    public function setStatus($status)
    {
        return $this->setData(self::KEY_SALE, $status);
    }

    public function setSale($sale)
    {
        return $this->setData(self::KEY_SALE, $sale);
    }
    public function getStoreId()
    {
        return $this->_get(self::KEY_STORE_ID);
    }
    public function setStoreId($store_id)
    {
        return $this->setData(self::KEY_STORE_ID, $store_id);
    }
    public function getFacebookId()
    {
        return $this->_get(self::KEY_FACEBOOK_ID);
    }
    public function setFacebookId($facebook_id)
    {
        return $this->setData(self::KEY_FACEBOOK_ID, $facebook_id);
    }
    public function getCommissionId()
    {
        return $this->_get(self::KEY_COMMISSION_ID);
    }
    public function setCommissionId($commission_id)
    {
        return $this->setData(self::KEY_COMMISSION_ID, $commission_id);
    }
    public function getBannerPic()
    {
        return $this->_get(self::KEY_BANNER_PIC);
    }
    public function setBannerPic($banner_pic)
    {
        return $this->setData(self::KEY_BANNER_PIC, $banner_pic);
    }
    public function getGplusId()
    {
        return $this->_get(self::KEY_GPLUS_ID);
    }
    public function setGplusId($gplus_id)
    {
        return $this->setData(self::KEY_GPLUS_ID, $gplus_id);
    }
    public function getInstagramId()
    {
        return $this->_get(self::KEY_INSTAGRAM_ID);
    }
    public function setInstagramId($instagram_id)
    {
        return $this->setData(self::KEY_INSTAGRAM_ID, $instagram_id);
    }
    public function getInstagramActive()
    {
        return $this->_get(self::KEY_INSTAGRAM_ACTIVE);
    }
    public function setInstagramActive($instagram_active)
    {
        return $this->setData(self::KEY_INSTAGRAM_ACTIVE, $instagram_active);
    }
    public function getGplusActive()
    {
        return $this->_get(self::KEY_GPLUS_ACTIVE);
    }
    public function setGplusActive($gplus_active)
    {
        return $this->setData(self::KEY_GPLUS_ACTIVE, $gplus_active);
    }
    public function getLinkedinId()
    {
        return $this->_get(self::KEY_LINKEDIN_ID);
    }
    public function setLinkedinId($linkedin_id)
    {
        return $this->setData(self::KEY_LINKEDIN_ID, $linkedin_id);
    }
    public function getLogoPic()
    {
        return $this->_get(self::KEY_LOGO_PIC);
    }
    public function setLogoPic($logo_pic)
    {
        return $this->setData(self::KEY_LOGO_PIC, $logo_pic);
    }
    public function getLinkedinActive()
    {
        return $this->_get(self::KEY_LINKEDIN_ACTIVE);
    }
    public function setLinkedinActive($linkedin_active)
    {
        return $this->setData(self::KEY_LINKEDIN_ACTIVE, $linkedin_active);
    }
    public function getPageLayout()
    {
        return $this->_get(self::KEY_PAGE_LAYOUT);
    }
    public function setPageLayout($page_layout)
    {
        return $this->setData(self::KEY_PAGE_LAYOUT, $page_layout);
    }
    public function getPinterestActive()
    {
        return $this->_get(self::KEY_PINTEREST_ACTIVE);
    }
    public function setPinterestActive($pinterest_active)
    {
        return $this->setData(self::KEY_PINTEREST_ACTIVE, $pinterest_active);
    }
    public function getPinterestId()
    {
        return $this->_get(self::KEY_PINTEREST_ID);
    }
    public function setPinterestId($pinterest_id)
    {
        return $this->setData(self::KEY_PINTEREST_ID, $pinterest_id);
    }
    public function getSale()
    {
        return $this->_get(self::KEY_SALE);
    }
    public function getShopUrl()
    {
        return $this->_get(self::KEY_SHOP_URL);
    }
    public function setShopUrl($shop_url)
    {
        return $this->setData(self::KEY_SHOP_URL, $shop_url);
    }
    public function getPosition()
    {
        return $this->_get(self::KEY_POSITION);
    }
    public function setPosition($position)
    {
        return $this->setData(self::KEY_POSITION, $position);
    }
    public function getTwitterId()
    {
        return $this->_get(self::KEY_TWITTER_ID);
    }
    public function setTwitterId($twitter_id)
    {
        return $this->setData(self::KEY_TWITTER_ID, $twitter_id);
    }
    public function getTwActive()
    {
        return $this->_get(self::KEY_TW_ACTIVE);
    }
    public function setTwActive($tw_active)
    {
        return $this->setData(self::KEY_TW_ACTIVE, $tw_active);
    }
    public function getVimeoId()
    {
        return $this->_get(self::KEY_VIMEO_ID);
    }
    public function setVimeoId($vimeo_id)
    {
        return $this->setData(self::KEY_VIMEO_ID, $vimeo_id);
    }
    public function getVimeoActive()
    {
        return $this->_get(self::KEY_VIMEO_ACTIVE);
    }
    public function setVimeoActive($vimeo_active)
    {
        return $this->setData(self::KEY_VIMEO_ACTIVE, $vimeo_active);
    }
    public function getYoutubeId()
    {
        return $this->_get(self::KEY_YOUTUBE_ID);
    }
    public function setYoutubeId($youtube_id)
    {
        return $this->setData(self::KEY_YOUTUBE_ID, $youtube_id);
    }

    public function getFbActive()
    {
        return $this->_get(self::KEY_FB_ACTIVE);
    }
    public function setFbActive($fb_active)
    {
        return $this->setData(self::KEY_FB_ACTIVE, $fb_active);
    }

    public function getSellerId(){
        return $this->_get(self::KEY_SELLER_ID);
    }
    public function setSellerId($sellerId){
        return $this->setData(self::KEY_SELLER_ID, $sellerId);
    }
    public function getCustomerId()
    {
        return $this->_get(self::KEY_CUSTOMER_ID);
    }
    public function setCustomerId($customer_id)
    {
        return $this->setData(self::KEY_CUSTOMER_ID, $customer_id);
    }
    public function getName()
    {
        return $this->_get(self::KEY_NAME);
    }
    public function setName($name)
    {
        return $this->setData(self::KEY_NAME, $name);
    }
    public function getEmail()
    {
        return $this->_get(self::KEY_NAME);
    }
    public function setEmail($email)
    {
        return $this->setData(self::KEY_EMAIL, $email);
    }

    public function getContactNumber(){
        return $this->_get(self::KEY_CONTACT_NUMBER);
    }
    public function setContactNumber($contact_number){
        return $this->setData(self::KEY_CONTACT_NUMBER, $contact_number);
    }
    public function getShopTitle(){
        return $this->_get(self::KEY_SHOP_TITLE);
    }
    public function setShopTitle($shop_title){
        return $this->setData(self::KEY_SHOP_TITLE, $shop_title);
    }
    public function getCompanyLocality(){
        return $this->_get(self::KEY_COMPANY_LOCALITY);
    }
    public function setCompanyLocality($company_locality){
        return $this->setData(self::KEY_COMPANY_LOCALITY, $company_locality);
    }
    public function getCompanyDescription(){
        return $this->_get(self::KEY_COMPANY_DESCRIPTION);
    }
    public function setCompanyDescription($company_description){
        return $this->setData(self::KEY_COMPANY_DESCRIPTION, $company_description);
    }
    public function getReturnPolicy(){
        return $this->_get(self::KEY_RETURN_POLICY);
    }
    public function setReturnPolicy($return_policy){
        return $this->setData(self::KEY_RETURN_POLICY, $return_policy);
    }
    public function getShippingPolicy(){
        return $this->_get(self::KEY_SHIPPING_POLICY);
    }
    public function setShippingPolicy($shipping_policy){
        return $this->setData(self::KEY_SHIPPING_POLICY, $shipping_policy);
    }
    public function getAddress(){
        return $this->_get(self::KEY_ADDRESS);
    }
    public function setAddress($address){
        return $this->setData(self::KEY_ADDRESS, $address);
    }
    public function getCountry(){
        return $this->_get(self::KEY_COUNTRY);
    }
    public function setCountry($country){
        return $this->setData(self::KEY_COUNTRY, $country);
    }
    public function getImage(){
        return $this->_get(self::KEY_IMAGE);
    }
    public function setImage($image){
        return $this->setData(self::KEY_IMAGE, $image);
    }
    public function getThumbnail(){
        return $this->_get(self::KEY_THUMBNAIL);
    }
    public function setThumbnail($thumbnail){
        return $this->setData(self::KEY_THUMBNAIL, $thumbnail);
    }
    public function getCity(){
        return $this->_get(self::KEY_CITY);
    }
    public function setCity($city){
        return $this->setData(self::KEY_CITY, $city);
    }
    public function getRegion(){
        return $this->_get(self::KEY_REGION);
    }
    public function setRegion($region){
        return $this->setData(self::KEY_REGION, $region);
    }
	
    public function getGroup(){
        return $this->_get(self::KEY_GROUP);
    }

    public function setGroup($group){
        return $this->setData(self::KEY_GROUP, $group);
    }
    public function getUrl(){
        return $this->_get(self::KEY_URL);
    }
	
    public function setUrl($url){
        return $this->setData(self::KEY_URL, $url);
    }

}
