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
 * @package    Lofmp_SplitCart
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SplitCart\Plugin;

use Lofmp\SplitCart\Helper\ConfigData;

/**
 * Class ModifyQuote
 * @package Lofmp\SplitCart\Plugin
 */
class ModifyLayout {

    private $moduleConfig;

    /**
     * ModifyLayout constructor.
     * @param ConfigData $moduleConfig
     */
    public function __construct(ConfigData $moduleConfig) {
        $this->moduleConfig = $moduleConfig;
    }

    /**
     * @param \Magento\Checkout\Block\Cart $subject
     * @return null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeToHtml(\Magento\Checkout\Block\Cart $subject){
        if($this->moduleConfig->isEnabled()){
            $layout = $subject->getLayout();
            $layout->unsetElement('checkout.cart.shipping');
            $layout->unsetElement('checkout.cart.totals.container');
            $layout->unsetElement('checkout.cart.coupon');
            $layout->unsetElement('additional.product.info');
            $layout->unsetElement('checkout.cart.methods.multishipping');

//            $totalsBlock = $subject->getLayout()->createBlock('Lofmp\SplitCart\Block\Cart\Totals');
//            $subject->setChild('custom-totals', $totalsBlock);
        }

        return null;
    }
}