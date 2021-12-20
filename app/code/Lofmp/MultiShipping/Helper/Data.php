<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lofmp_Dhlshipping
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lofmp\MultiShipping\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $_helper;

    protected $_objectManager;

    public function __construct(\Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {

        $this->_objectManager = $objectManager;
        parent::__construct($context);
        $this->_helper = $this->_objectManager->get('Lof\MarketPlace\Helper\Data');
    }

    public function isEnabled($storeId = 0)
    {
        if($storeId == 0) {
            $storeId = $this->_helper->getStore()->getId();
        }
        return $this->getConfig('general/activation', $storeId);
    }
     /**
     * Return seller config value by key and store
     *
     * @param string $key
     * @param \Magento\Store\Model\Store|int|string $store
     * @return string|null
     */
    public function getConfig($key, $store = null)
    {
        $result = $this->scopeConfig->getValue(
            'lofmp_multishipping/'.$key,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store);
        return $result;
    }
    public function getConfigValue($key='',$sellerId=0)
    {
        $value=false;
        if(strlen($key)>0 && $sellerId) {
            $key_tmp = $this->_helper->getTableKey('key');
            $seller_id_tmp  = $this->_helper->getTableKey('seller_id');
            $config = $this->_objectManager->get('Lof\MarketPlace\Model\Config')
                ->loadByField(array($key_tmp,$seller_id_tmp), array($key,(int)$sellerId));
            if($config && $config->getSettingId()) {
                $value = $config->getValue();
            }
        }
        return $value;
    }

    public function getActiveSellerMethods($sellerId=0)
    {
        $methods = $this->_objectManager->get('Lofmp\MultiShipping\Model\Source\Shipping\Methods')->getMethods();
        $SellerMethods=array();
        if(count($methods) >0 ) {
            $sellerShippingConfig = $this->getShippingConfig($sellerId);
            foreach($methods as $code => $method) {
                $model=$this->_objectManager->create($method['model']);
                $key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/'.$code.'/active');
                //if(isset($sellerShippingConfig[$key]['value']) && $sellerShippingConfig[$key]['value']) {
                    $fields = $model->getFields();
                    if (count($fields) > 0) {
                        foreach ($fields as $id=>$field) {
                            //$key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/'.$code.'/'.$id);
                           // if(isset($sellerShippingConfig[$key])) {
                                $SellerMethods[$code][$id] = 1;
                            //}
                        }
                    }
               // }
            }
            return $SellerMethods;
        }
        else {
            return $SellerMethods;
        }
    }

    public function getSellerMethods($sellerId = 0)
    {
        $methods = $this->_objectManager->get('Lofmp\MultiShipping\Model\Source\Shipping\Methods')->getMethods();
        $SellerMethods=array();
        if(count($methods) >0 ) {
            $sellerShippingConfig = $this->getShippingConfig($sellerId);

            foreach($methods as $code=>$method) {
                $model=Mage::getModel($method['model']);
                $fields = $model->getFields();
                if (count($fields) > 0) {
                    foreach ($fields as $id=>$field) {
                        $key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/'.$code.'/'.$id);
                        if(isset($sellerShippingConfig[$key])) {
                            $SellerMethods[$code][$id] = $sellerShippingConfig[$key]['value'];
                        }
                    }
                }
            }
            return $SellerMethods;
        }
        else {
            return $SellerMethods;
        }
    }

    public function getSellerAddress($sellerId=0)
    {
        $SellerAddress = array();
        $model= $this->_objectManager->get('Lofmp\MultiShipping\Model\Config\Shipping\Address');
        $sellerShippingConfig = $this->getShippingConfig($sellerId);
        $fields = $model->getFields();
        if (count($fields) > 0) {
            foreach ($fields as $id=>$field) {
                $key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/address/'.$id);
                if(isset($sellerShippingConfig[$key]) && strlen($sellerShippingConfig[$key]['value'])>0) {
                    $SellerAddress[$id] = $sellerShippingConfig[$key]['value'];
                }
            }
        }
        return $SellerAddress;
    }

    public function getShippingConfig($sellerId=0)
    {
        $values=array();
        if($sellerId) {
            $group = $this->_helper->getTableKey('group');
            $seller_id = $this->_helper->getTableKey('seller_id');
            $config = $this->_objectManager->create('Lof\MarketPlace\Model\Config')->getCollection()
                ->addFieldToFilter($group, array('eq'=> \Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION))
                ->addFieldToFilter($seller_id, array('eq'=>$sellerId));
            if($config && count($config->getData())>0) {
                foreach($config->getData() as $index => $value){
                    $values[$value['key']]=$value;
                }
            }
        }
        return $values;
    }

    public function saveShippingData($section, $groups, $seller_id)
    {
        foreach ($groups as $code=>$values) {
            if(is_array($values) && count($values)>0) {
                foreach ($values as $name=>$value) {
                    $serialized = 0;
                    $key = strtolower($section.'/'.$code.'/'.$name);
                    if (is_array($value)) {
                        $value = implode(",", $value);
                        //$value = serialize($value);
                        //$serialized = 1;
                    }
                    $key_tmp = $this->_helper->getTableKey('key');
                    $seller_id_tmp = $this->_helper->getTableKey('seller_id');
                    $setting = $this->_objectManager->create('Lof\MarketPlace\Model\Config')
                        ->loadByField(array($key_tmp,$seller_id_tmp), array($key,$seller_id));
                    if ($setting && $setting->getId()) {
                        $setting->setSellerId($seller_id)
                            ->setGroup($section)
                            ->setKey($key)
                            ->setValue($value)
                            ->setSerialized($serialized)
                            ->save();
                    } else {
                        $setting = $this->_objectManager->create('Lof\MarketPlace\Model\Config');
                        $setting->setSellerId($seller_id)
                            ->setGroup($section)
                            ->setKey($key)
                            ->setValue($value)
                            ->setSerialized($serialized)
                            ->save();
                    }
                }
            }
        }
    }

    public function validateAddress($sellerAddress=array())
    {
        $flag=true;
        if(!isset($sellerAddress['country_id']) || !isset($sellerAddress['city']) || !isset($sellerAddress['postcode'])) {
            return false;
        }
//        if(!isset($sellerAddress['region_id']) &&!isset($sellerAddress['region'])) {
//            return false;
//        }
        if(isset($sellerAddress['country_id']) && !$sellerAddress['country_id']) {
            return false;
        }
//        if(isset($sellerAddress['region_id']) && !$sellerAddress['region_id']) {
//            return false;
//        }
//        if(isset($sellerAddress['region']) && !$sellerAddress['region']) {
//            return false;
//        }
        if(!isset($sellerAddress['city']) && !$sellerAddress['city']) {
            return false;
        }
        if(!isset($sellerAddress['postcode']) && !$sellerAddress['postcode']) {
            return false;
        }
        return $flag;
    }

    public function validateSpecificMethods($activeMethods)
    {
        if(count($activeMethods)>0) {
            $methods = $this->_objectManager->get('Lofmp\MultiShipping\Model\Source\Shipping\Methods')->getMethods();
            foreach ($activeMethods as $method => $methoddata){
                if(isset($methods[$method]['model'])) {
                    $model = $this->_objectManager->get($methods[$method]['model'])->validateSpecificMethod($activeMethods[$method]);
                    if(!$model) {
                        return false;
                    }
                }
            }
            return true;
        }
        else {
            return false;
        }
    }
}
