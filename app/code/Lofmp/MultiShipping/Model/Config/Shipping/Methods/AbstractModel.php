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
 * @package    Lofmp_MultiShipping
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
 
 namespace Lofmp\MultiShipping\Model\Config\Shipping\Methods;
 
class AbstractModel extends \Lof\MarketPlace\Model\FlatAbstractModel
{
    const SHIPPING_SECTION = 'shipping';
    protected $_code = '';
    protected $_fields = array();
    protected $_codeSeparator = '-';
    
    /**
     * Get current store
     *
     * @return Mage_Core_Model_Store
     */
     
    public function getStore() 
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        if($storeId) {
            return $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStore($storeId); 
        }
        else { 
            return $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStore(); 
        }
    }
     
    /**
     * Get current store
     *
     * @return Mage_Core_Model_Store
     */
     
    public function getStoreId() 
    {
        return $this->getStore()->getId();
    }
    
    
    /**
     * Get the code
     *
     * @return string
     */
    public function getCode() 
    {
        return $this->_code;
    }
    
    /**
     * Get the code separator
     *
     * @return string
     */
    public function getCodeSeparator() 
    {
        return $this->_codeSeparator;
    }
    
    /**
     *  Retreive input fields
     *
     * @return array
     */
    public function getFields() 
    {
        $this->_fields = array();
        $this->_fields['active'] = array('type'=>'select',
                                        'values'=>array(array('label'=>__('Yes'), 'value'=>1),
                                        array('label'=>__('No'), 'value'=>0))
                                    );
        return $this->_fields;
    }
    
    /**
     * Retreive labels
     *
     * @param  string $key
     * @return string
     */
    public function getLabel($key) 
    {
        switch($key) {
        case 'active' : 
            return __('Active'); break;
        default : 
            return __($key); break;
        }
    }
    
    public function validateSpecificMethod($methodData)
    {
        if(count($methodData)>0) {
            return true;
        }
        else {
            return false; 
        }
    }
}
