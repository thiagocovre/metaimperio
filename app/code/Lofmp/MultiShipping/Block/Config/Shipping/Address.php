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
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lofmp\MultiShipping\Block\Config\Shipping;
 
class Address extends \Lof\MarketPlace\Block\Seller\AbstractBlock
{
    /**
     * Preparing global layout
     *
     * You can redefine this method in child classes for changin layout
     *
     * @return Lof_MarketPlace_Block_Seller_Abstract
     */
    protected function _prepareLayout() 
    {
        \Magento\Framework\Data\Form::setElementRenderer(
            $this->getLayout()->createBlock('Lof\MarketPlace\Block\Widget\Form\Renderer\Element')
        );
        \Magento\Framework\Data\Form::setFieldsetRenderer(
            $this->getLayout()->createBlock('Lof\MarketPlace\Block\Widget\Form\Renderer\Fieldset')
        );
        \Magento\Framework\Data\Form::setFieldsetElementRenderer(
            $this->getLayout()->createBlock('Lof\MarketPlace\Block\Widget\Form\Renderer\Fieldset\Element')
        );
        return parent::_prepareLayout();
    }
    
    /**
     * Get form object
     *
     * @return Varien_Data_Form
     */
    public function getForm()
    {
        return $this->_form;
    }
    
    /**
     * Get form object
     *
     * @deprecated deprecated since version 1.2
     * @see        getForm()
     * @return     Varien_Data_Form
     */
    public function getFormObject()
    {
        return $this->getForm();
    }
    
    /**
     * Get form HTML
     *
     * @return string
     */
    public function getFormHtml()
    {
        if (is_object($this->getForm())) {
            return $this->getForm()->getHtml();
        }
        return '';
    }
    
    /**
     * Set form object
     *
     * @param  Varien_Data_Form $form
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    public function setForm(\Magento\Framework\Data\Form $form)
    {
        $this->_form = $form;
        $this->_form->setParent($this);
        $this->_form->setBaseUrl($this->getBaseUrl());
        return $this;
    }
    
    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {    
        $form = $this->_objectManager->get('Magento\Framework\Data\Form');
        $form->setAction($this->getUrl('*/settings/save', array('section'=>\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION)))
            ->setId('form-validate')
            ->setMethod('POST')
            ->setEnctype('multipart/form-data')
            ->setUseContainer(true);
        $seller = $this->getSeller();    
        $methods = array();
        $model = $this->_objectManager->get('Lofmp\MultiShipping\Model\Config\Shipping\Address');

        $code='address';
        $fields = $model->getFields();
        if (count($fields) > 0) {
            $key_tmp = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getTableKey('key');
            $seller_id_tmp = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getTableKey('seller_id');
            $fieldset = $form->addFieldset('multishipping_'.$code, array('legend'=>$model->getLabel('label')));
            foreach ($fields as $id=>$field) {
                $key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/'.$code.'/'.$id);
                $value = '';
                $setting = $this->_objectManager->create('Lof\MarketPlace\Model\Config')
                    ->loadByField(array($key_tmp,$seller_id_tmp), array($key,(int)$seller->getId()));
                if($setting) {
                    $value = $setting->getValue(); 
                }
                $fieldset->addField(
                    $code.$model->getCodeSeparator().$id, isset($field['type'])?$field['type']:'text', array(
                    strlen($model->getLabel($id))>0?'label':''                     => strlen($model->getLabel($id))>0?$model->getLabel($id):'',
                    'value'                                                      => $value,
                    'name'                                                      => "groups[".$code."][".$id."]",
                    isset($field['class'])?'class':''                           => isset($field['class'])?$field['class']:'',
                    isset($field['required'])?'required':''                        => isset($field['required'])?$field['required']:'',
                    isset($field['onchange'])?'onchange':''                        => isset($field['onchange'])?$field['onchange']:'',
                    isset($field['onclick'])?'onclick':''                        => isset($field['onclick'])?$field['onclick']:'',
                    isset($field['href'])?'href':''                                => isset($field['href'])?$field['href']:'',
                    isset($field['target'])?'target':''                            => isset($field['target'])?$field['target']:'',
                    isset($field['values'])? 'values': ''                         => isset($field['values'])? $field['values']: '',
                    isset($field['after_element_html'])? 'after_element_html':''=> isset($field['after_element_html'])? '<div><small>'.$field['after_element_html'].'</small></div>': '',
                    )
                );
            }
        }
        $this->setForm($form);
        
        return $this;
    }
    
    public function getRegionId()
    {
        $key_tmp = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getTableKey('key');
        $seller_id_tmp = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getTableKey('seller_id');
        $key = strtolower(\Lofmp\MultiShipping\Model\Config\Shipping\Methods\AbstractModel::SHIPPING_SECTION.'/address/region_id');
        $addressmodel = $this->_objectManager->create('Lof\MarketPlace\Model\Config')
            ->loadByField(array($key_tmp,$seller_id_tmp), array($key,(int)$this->getSeller()->getId()));
        return $addressmodel->getValue();
    }
    
    
    /**
     * This method is called before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _beforeToHtml()
    {
        $this->_prepareForm();
        $this->_initFormValues();
        return parent::_beforeToHtml();
    }
    
    /**
     * Initialize form fields values
     * Method will be called after prepareForm and can be used for field values initialization
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _initFormValues()
    {
        return $this;
    }
    
    /**
     * Set Fieldset to Form
     *
     * @param array                             $attributes attributes that are to be added
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     * @param array                             $exclude    attributes that should be skipped
     */
    protected function _setFieldset($attributes, $fieldset, $exclude=array())
    {
        $this->_addElementTypes($fieldset);
        foreach ($attributes as $attribute) {
            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
            if (!$attribute || ($attribute->hasIsVisible() && !$attribute->getIsVisible())) {
                continue;
            }
            if (($inputType = $attribute->getFrontend()->getInputType())
                && !in_array($attribute->getAttributeCode(), $exclude)
                && ('media_image' != $inputType)
            ) {
    
                $fieldType      = $inputType;
                $rendererClass  = $attribute->getFrontend()->getInputRendererClass();
                if (!empty($rendererClass)) {
                    $fieldType  = $inputType . '_' . $attribute->getAttributeCode();
                    $fieldset->addType($fieldType, $rendererClass);
                }
    
                $element = $fieldset->addField(
                    $attribute->getAttributeCode(), $fieldType,
                    array(
                                'name'      => $attribute->getAttributeCode(),
                                'label'     => $attribute->getFrontend()->getLabel(),
                                'class'     => $attribute->getFrontend()->getClass(),
                                'required'  => $attribute->getIsRequired(),
                                'note'      => $attribute->getNote(),
                    )
                )
                    ->setEntityAttribute($attribute);
    
                $element->setAfterElementHtml($this->_getAdditionalElementHtml($element));
    
                if ($inputType == 'select') {
                    $element->setValues($attribute->getSource()->getAllOptions(true, true));
                } else if ($inputType == 'multiselect') {
                    $element->setValues($attribute->getSource()->getAllOptions(false, true));
                    $element->setCanBeEmpty(true);
                } else if ($inputType == 'date') {
                    $element->setImage($this->getSkinUrl('images/calendar.gif'));
                    $element->setFormat($this->getDateFormat(\IntlDateFormatter::SHORT));
                } else if ($inputType == 'datetime') {
                    $element->setImage($this->getSkinUrl('images/calendar.gif'));
                    $element->setTime(true);
                    $element->setStyle('width:50%;');
                    $element->setFormat($this->getDateTimeFormat(\IntlDateFormatter::SHORT));
                } else if ($inputType == 'multiline') {
                    $element->setLineCount($attribute->getMultilineCount());
                }
            }
        }
    }
    
    /**
     * Add new element type
     *
     * @param Varien_Data_Form_Abstract $baseElement
     */
    protected function _addElementTypes(\Magento\Framework\Data\Form\AbstractForm $baseElement)
    {
        $types = $this->_getAdditionalElementTypes();
        foreach ($types as $code => $className) {
            $baseElement->addType($code, $className);
        }
    }
    
    /**
     * Retrieve predefined additional element types
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        return array();
    }
    
    /**
     * Enter description here...
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getAdditionalElementHtml($element)
    {
        return '';
    }
    
    
}
