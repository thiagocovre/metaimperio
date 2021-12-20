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
 
namespace Lofmp\MultiShipping\Model\System\Config\Source;
 
class AbstractBlock extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{

    protected $_objectManager;

    /**
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory            $attrOptionFactory
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory);
        $this->_objectManager = $objectManager;
    }

    /**
     * Retrieve Full Option values array
     *
     * @param  bool $withEmpty     Add empty option to array
     * @param  bool $defaultValues
     * @return array
     */
    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $storeId = $this->getAttribute()->getStoreId();
        $this->_options[$storeId] = $this->_optionsDefault[$storeId] = $this->toOptionArray($defaultValues);
        if (!is_array($this->_options)) {
            $this->_options = array();
        }
        if (!is_array($this->_optionsDefault)) {
            $this->_optionsDefault = array();
        }
        if (!isset($this->_options[$storeId])) {
            $collection = $this->_attrOptionCollectionFactory->create()
                ->setPositionOrder('asc')
                ->setAttributeFilter($this->getAttribute()->getId())
                ->setStoreFilter($this->getAttribute()->getStoreId())
                ->load();
            $this->_options[$storeId]        = $collection->toOptionArray($defaultValues);
            $this->_optionsDefault[$storeId] = $collection->toOptionArray($defaultValues);
        }
        $options = ($defaultValues ? $this->_optionsDefault[$storeId] : $this->_options[$storeId]);
        if ($withEmpty) {
            array_unshift($options, array('label' => '', 'value' => ''));
        }
        return $options;
    }
    
    
    public function getOptionText($value)
    {
        $isMultiple = false;
        if (strpos($value, ',')) {
            $isMultiple = true;
            $value = explode(',', $value);
        }
        
        $options = $this->getAllOptions(false);
        
        if ($isMultiple) {
            $values = [];
            foreach ($options as $key => $item) {
                if (in_array($key, $value)) {
                    $values[] = $item;
                }
            }
            return $values;
        }
        foreach ($options as $key => $item) {
            if ($key == $value) {
                return $item;
            }
        }
        return false;
    }
    
    /**
     * Retrieve options for grid filter
     *
     * @param  String $value
     * @return String
     */
    public function toFilterOptionArray($defaultValues = false, $withEmpty = false,$storeId=null) 
    {
        if($storeId==null) {
            $options = $this->toOptionArray($defaultValues, $withEmpty); 
        }
        else { 
            $options = $this->toOptionArray($defaultValues, $withEmpty, $storeId); 
        }
        $filterOptions = array();
        if(count($options)) {
            foreach($options as $option) {
                if(isset($option['value']) && isset($option['label'])) {
                    $filterOptions[$option['value']] = $option['label'];
                }
            }
        }
        return $filterOptions;
    }
    
    /**
     * Retrieve option label by option value
     *
     * @param  String $value
     * @return String
     */
    public function getLabelByValue($value = '') 
    {
        $options = $this->toOptionArray();
        if(count($options)) {
            foreach($options as $option) {
                if(isset($option['value']) && $option['value'] == $value) {
                    $value = isset($option['label'])?$option['label']:$value;
                    break;
                }
            }
        }
        return $value;
    }
    


}
