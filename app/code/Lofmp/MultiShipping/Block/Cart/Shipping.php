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


namespace Lofmp\MultiShipping\Block\Cart;

class Shipping extends \Magento\Checkout\Block\Cart\Shipping
{

    protected $_seller_rates;
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        array $layoutProcessors = [],
        array $data = []
    ) {
        parent::__construct($context, $customerSession, $checkoutSession, $configProvider, $layoutProcessors, $data);
        $this->_objectManager = $objectInterface;
    }

    public function getJsLayout()
    {

        if($this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {

            return str_replace("Magento_Checkout\/js\/view\/cart\/shipping-rates", "Lofmp_MultiShipping\/js/cart\/shipping-rates", parent::getJsLayout());
        }else{
            return parent::getJsLayout();
        }
    }

}
