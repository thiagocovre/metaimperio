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
 
namespace Lofmp\MultiShipping\Observer; 
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
Class SellerSaveBefore implements ObserverInterface
{
    
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
    protected $_quoteFactory;
    
    public function __construct(        
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
            
        $this->_objectManager = $objectManager;
        $this->_quoteFactory = $quoteFactory;
    }
    
    /**
     * Adds catalog categories to top menu
     *
     * @param  \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    { 
    	
        if($this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            $vorder = $observer->getEvent()->getvorder();
            if (!$vorder->getId()) {
                $order = $vorder->getOrder();
                $quoteId = $order->getQuoteId();
                if ($quoteId) {
                    $quote = $this->_quoteFactory->create()->load($quoteId);
                    if ($quote && $quote->getId()) {
                        $addresses = $quote->getAllShippingAddresses();
                        foreach ($addresses as $address) {
                            if ($address) {
                                $shippingMethod = $address->getShippingMethod();
                                if (substr($shippingMethod, 0, 12) == 'seller_rates') {
                                    $shippingMethod = str_replace('seller_rates_', '', $shippingMethod);
                                }
                                $shippingMethods = explode(\Lofmp\MultiShipping\Model\Shipping::METHOD_SEPARATOR, $shippingMethod);
                                $sellerId = 0;
                                foreach ($shippingMethods as $method) {
                                    $rate = $address->getShippingRateByCode($method);
                                    $methodInfo = explode(\Lofmp\MultiShipping\Model\Shipping::SEPARATOR, $method);
                                    if (sizeof($methodInfo)!= 2) {
                                        continue;
                                    }
                                    $sellerId = isset($methodInfo [1])?$methodInfo[1]:"admin";
                                        
                                    if ($sellerId == $vorder->getSellerId()) {
                                        $vorder->setShippingAmount($this->_objectManager->get('Magento\Directory\Helper\Data')->currencyConvert($rate->getPrice(), $order->getBaseCurrencyCode(), $order->getGlobalCurrencyCode()));
                                        $vorder->setBaseShippingAmount($rate->getPrice());
                                        $vorder->setCarrier($rate->getCarrier());
                                        $vorder->setCarrierTitle($rate->getCarrierTitle());
                                        $vorder->setMethod($rate->getMethod());
                                        $vorder->setMethodTitle($rate->getMethodTitle());
                                        $vorder->setCode($method);
                                        $vorder->setShippingDescription($rate->getCarrierTitle()."-".$rate->getMethodTitle());
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }            
        
    }
   
        
}