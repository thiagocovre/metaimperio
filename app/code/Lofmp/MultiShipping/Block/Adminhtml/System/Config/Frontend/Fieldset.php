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
 
class Fieldset  extends \Magento\Config\Block\System\Config\Form\Fieldset
{

    protected $_objectManager;

    protected $helper;
    
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Lof\MarketPlace\Helper\Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data);
        $this->_objectManager = $objectManager;
        $this->helper = $helper;

    }
    
    /**
     * Render fieldset html
     *
     * @param  Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
            
        $this->setElement($element);
        $html = $this->_getHeaderHtml($element);
        if($websitecode = $this->getRequest()->getParam('website')) {

            $website = $this->_objectManager->get('Magento\Store\Model\Website')->load($websitecode);
            
            if($website && $website->getWebsiteId()) {
                $active = $website->getConfig('lofmp_multishipping/general/activation')?1:0;
            }
        } else {
            $active = $this->helper->getStoreConfig('lofmp_multishipping/general/activation')?1:0; 
        }
        $validation = $active ?0:1;
        
        foreach ($element->getElements() as $field) {
            if ($field instanceof \Magento\Framework\Data\Form\Element\Fieldset) {
                $html .= '<tr id="row_' . $field->getHtmlId() . '"><td colspan="4">' . $field->toHtml() . '</td></tr>';
            } else {
                $html .= $field->toHtml();
            }
        }
        
        $html .= $this->_getFooterHtml($element);
        $html.='<script>
        		var enable=0;
				
				if('.$validation.'){
					document.getElementById("'.$element->getHtmlId().'").style.display="none";
					document.getElementById("'.$element->getHtmlId().'-state").previousElementSibling.style.display="none";
					document.getElementById("'.$element->getHtmlId().'-state").style.display="none";
				}
				</script>';
        return $html;
    }
}
