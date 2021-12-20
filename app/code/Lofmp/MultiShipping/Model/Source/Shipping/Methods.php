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

namespace Lofmp\MultiShipping\Model\Source\Shipping;

class Methods extends \Lofmp\MultiShipping\Model\System\Config\Source\AbstractBlock
{

    const XML_PATH_LOFMP_MULTISHIPPING_SHIPPING_METHODS = 'lofmp_multishipping/shipping/methods';

    protected $scopeConfig;

    protected $_objectManager;

    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory $attrOptionFactory,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($attrOptionCollectionFactory, $attrOptionFactory, $objectManager);
        $this->scopeConfig = $scopeConfig;
        $this->_objectManager = $objectManager;
    }


    /**
     * Retrieve rates data form config.xml
  *
     * @return array
     */

    public function getMethods()
    {

        $rates = $this->scopeConfig->getValue(
            self::XML_PATH_LOFMP_MULTISHIPPING_SHIPPING_METHODS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStore()
        );


        $allowedmethods = array();
        if(is_array($rates) && count($rates)>0) {
            foreach ($rates as $code => $method){
                if($this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig($method['config_path'], $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStore()->getId())) {
                    $allowedmethods[$code] = $rates[$code];
                }
            }
        }

        return $allowedmethods;
    }
    /**
     * Retrieve Option values array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $methods = array_keys(self::getMethods());
        $options = array();
        foreach($methods as $method) {
            $method = strtolower(trim($method));
            $options[] = array('value'=>$method,'label'=> __(ucfirst($method)));
        }
        return $options;
    }

}
