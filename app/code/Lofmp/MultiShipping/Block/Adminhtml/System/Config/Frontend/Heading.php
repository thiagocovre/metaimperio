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
 
class Heading extends \Magento\Config\Block\System\Config\Form\Field\Heading
{
    
    protected $_objectManager;
    
    protected $_request;
    
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\RequestInterface $request
    ) {
    
        $this->_request = $request;
        $this->_objectManager = $objectManager;
    }
    
    
    /**
     * Render element html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $useContainerId = $element->getData('use_container_id');
        $active = 1;
        if($websitecode = $this->_request->getParam('website')) {
            $website = $this->_objectManager->get('Magento\Store\Model\Website')->load($websitecode);
            if($website && $website->getWebsiteId()) {
                $active = $website->getConfig('lofmp_multishipping/general/activation')?1:0;
            }
        }
        else {
            $active = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig('lofmp_multishipping/general/activation')?1:0; 
        }
       
        $methods = $this->_objectManager->get('Lofmp\MultiShipping\Model\Source\Shipping\Methods')->getMethods();
        $count=0;
        if(count($methods)>0) {
            $count=1; 
        }
        $validation = $active && $count?0:1;

        $html='';
        $html.=sprintf(
            '<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5"><h4 id="%s">%s</h4></td></tr>',
            $element->getHtmlId(), $element->getHtmlId(), $element->getLabel()
        );
        $html.='<script>
				if('.$validation.'){
					document.getElementById("row_'.$element->getHtmlId().'").style.display="none";
				}
				</script>';
        return $html;
    }
    
       
}
