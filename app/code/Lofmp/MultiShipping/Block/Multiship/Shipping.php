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

namespace Lofmp\MultiShipping\Block\Multiship;


class Shipping extends \Magento\Multishipping\Block\Checkout\Shipping
{
    protected $_objectManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Filter\DataObject\GridFactory $filterGridFactory,
        \Magento\Multishipping\Model\Checkout\Type\Multishipping $multishipping,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        array $data = []
    ) {
        parent::__construct($context, $filterGridFactory, $multishipping, $taxHelper, $priceCurrency, $data);
        $this->_objectManager = $objectInterface;

    }


    protected function _prepareLayout()
    {
        if(!$this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            $this->setTemplate('Magento_Multishipping::checkout/shipping.phtml');
        }
        return parent::_prepareLayout();
    }

    public function getSelectedMethod($address)
    {
        $selectedMethod = str_replace("seller_rates_", '', $address->getShippingMethod());
        $selectedMethods = explode(\Lofmp\MultiShipping\Model\Shipping::METHOD_SEPARATOR, $selectedMethod);
        return $selectedMethods;
    }

    /**
     * @param Address $address
     * @return mixed
     */
    public function getShippingRates($address)
    {
        if(!$this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            return parent::getShippingRates($address);
        }
        $groups = $address->getGroupedAllShippingRates();

        $rates = array();
        foreach($groups as $code => $_rates){
            if($code == 'seller_rates') {
                foreach ($_rates as $rate) {
                    if (!$rate->isDeleted()) {
                        if (!isset($rates[$rate->getCarrier()])) {
                            $rates[$rate->getCarrier()] = array();
                        }
                        $rates[$rate->getCarrier()][] = $rate;
                    }
                }
            }
        }
        return $rates;
    }

    public function getRatesBySeller($address)
    {

        $addrs_mthd = $address->getGroupedAllShippingRates();
        $groups = array();

        foreach($addrs_mthd as $code => $rateCollection){
            foreach($rateCollection as $rate){
                if($rate->isDeleted()) {
                    continue;
                }
                if($rate->getCarrier() == 'seller_rates') {
                    continue;
                }

                $tmp = explode(\Lofmp\MultiShipping\Model\Shipping::SEPARATOR, $rate->getCode());

                $sellerId = isset($tmp[1])? $tmp[1] : "admin";

                $seller = $this->_objectManager->create('Lof\MarketPlace\Model\Seller');
                if($sellerId && $sellerId!="admin") {
                    $seller = $seller->load($sellerId);
                }

                if(!isset($groups[$sellerId])) {
                    $groups[$sellerId] = array();
                }

                $groups[$sellerId]['title'] = $seller->getId()? $seller->getPublicName(): $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStore()->getWebsite()->getName();

                if(!isset($groups[$sellerId]['rates'])) {
                    $groups[$sellerId]['rates'] = array();
                }
                $groups[$sellerId]['rates'][] = $rate;
            }
        }
        return $groups;
    }


}
