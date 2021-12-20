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

 
namespace Lofmp\MultiShipping\Block\Adminhtml\System\Config\Frontend;
 
class Enable extends \Magento\Config\Block\System\Config\Form\Field
{
    protected $_objectManager;
    
    public function __construct(\Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,    
        array $data = []
    ) {
    
        parent::__construct($context, $data);
        $this->_objectManager = $objectManager;
    }
    
    /**
     * Return element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {    
        
        if($websitecode = $this->getRequest()->getParam('website')) {
            $website = $this->_objectManager->get('Magento\Store\Model\Website')->load($websitecode);
            if($website && $website->getWebsiteId()) {
                $active = $website->getConfig('lofmp_multishipping/general/activation')?0:1;
            }
        }
        else {
            $active = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig('lofmp_multishipping/general/activation')?0:1; 
        }
        $html='';
        $html.=$element->getElementHtml();
        $html.='<script>
				if('.$active.'){
					document.getElementById("row_'.$element->getHtmlId().'").style.display="none";
				}
				</script>';    
        return $html;
    }
       
}
