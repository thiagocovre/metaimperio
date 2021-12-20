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

namespace Lofmp\MultiShipping\Block;

/**
 * Onepage checkout block
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Onepage extends \Magento\Checkout\Block\Onepage
{

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        array $layoutProcessors = [],
        array $data = []
    ) {
        parent::__construct($context, $formKey, $configProvider, $layoutProcessors, $data);
        $this->_objectManager = $objectInterface;
    }


    /**
     * @return string
     */
    public function getJsLayout()
    {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }

        if($this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            return str_replace('"Magento_Checkout\/js\/view\/shipping"', '"Lofmp_MultiShipping\/js/view\/shipping"', \Zend_Json::encode($this->jsLayout));
        }else{
            return \Zend_Json::encode($this->jsLayout);
        }

    }
    public function getSellerCollection() {
        return $this->_objectManager->get('Lof\MarketPlace\Model\ResourceModel\Seller\Collection')->getData();
    }
    public function getMethodTitle() {
        return $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig('lofmp_multishipping/general/method_title');
    }
    public function getCarrierTitle() {
        return $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig('lofmp_multishipping/general/carrier_title');
    }

}
