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
 
namespace Lofmp\MultiShipping\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
 
class Sellerrates extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{

    protected $_code = 'seller_rates';
    protected $_isFixed = true;
   
    public function collectRates(RateRequest $request)
    {
        return false;
    }

    public function getAllowedMethods()
    {
        return array('seller_rates'=>$this->getConfigData('name'));
    }
}
