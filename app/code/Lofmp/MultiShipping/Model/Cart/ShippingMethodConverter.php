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
 * @package    Lofmp_Dhlshipping
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
 
namespace Lofmp\MultiShipping\Model\Cart;

/**
 * Quote shipping method data.
 */
class ShippingMethodConverter extends \Magento\Quote\Model\Cart\ShippingMethodConverter
{
    
    protected $_objectManager;

    /**
     * Constructs a shipping method converter object.
     *
     * @param \Magento\Quote\Api\Data\ShippingMethodInterfaceFactory $shippingMethodDataFactory Shipping method factory.
     * @param \Magento\Store\Model\StoreManagerInterface             $storeManager              Store manager interface.
     * @param \Magento\Tax\Helper\Data                               $taxHelper                 Tax data helper.
     */
    public function __construct(
        \Magento\Quote\Api\Data\ShippingMethodInterfaceFactory $shippingMethodDataFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Magento\Tax\Helper\Data $taxHelper
    ) {
        parent::__construct($shippingMethodDataFactory, $storeManager, $taxHelper);
        $this->_objectManager = $objectInterface;
    }

    /**
     * Converts a specified rate model to a shipping method data object.
     *
     * @param  string                                  $quoteCurrencyCode The quote currency code.
     * @param  \Magento\Quote\Model\Quote\Address\Rate $rateModel         The rate model.
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface Shipping method data object.
     */
    public function modelToDataObject($rateModel, $quoteCurrencyCode)
    {
        /**
 * @var \Magento\Directory\Model\Currency $currency 
*/
        if(!$this->_objectManager->get('Lofmp\MultiShipping\Helper\Data')->isEnabled()) {
            return parent::modelToDataObject($rateModel, $quoteCurrencyCode);
        }
        $currency = $this->storeManager->getStore()->getBaseCurrency();
        $errorMessage = $rateModel->getErrorMessage();
        $rate = $this->_objectManager->get('Magento\Quote\Model\ResourceModel\Quote\Address\Rate\Collection');
        
        /*$rateCode = $rate->addFieldToFilter('address_id',$rateModel->getData('address_id'));
        $code = array();
        foreach ($rateCode as $key => $_rateCode) {
            $code[] = $_rateCode->getCode();
        }
       
        $code = implode(":", $code);*/
        
        $tmp = explode(\Lofmp\MultiShipping\Model\Shipping::SEPARATOR, $rateModel->getCode());
     

        $sellerId = isset($tmp[1]) ? $tmp[1] : "admin";
        $seller = $this->_objectManager->create('Lof\MarketPlace\Model\Seller');
        if($sellerId && $sellerId != "admin") {
            $seller = $seller->load($sellerId);                       
        }
        
        $title = $seller->getId()? $seller->getName(): $this->_objectManager->get('Lof\MarketPlace\Helper\Data')
            ->getStore()->getWebsite()->getName();


        return $this->shippingMethodDataFactory->create()
            ->setCarrierCode($rateModel->getCarrier())
            ->setMethodCode($rateModel->getMethod())
            ->setCarrierTitle($title)
            ->setMethodTitle($rateModel->getMethodTitle())
            ->setAmount($currency->convert($rateModel->getPrice(), $quoteCurrencyCode))
            ->setBaseAmount($rateModel->getPrice())
            ->setAvailable(empty($errorMessage))
            ->setErrorMessage(empty($errorMessage) ? false : $errorMessage)
            ->setPriceExclTax($currency->convert($this->getShippingPriceWithFlag($rateModel, false), $quoteCurrencyCode))
            ->setPriceInclTax($currency->convert($this->getShippingPriceWithFlag($rateModel, true), $quoteCurrencyCode));
            
    }
    
    private function getShippingPriceWithFlag($rateModel, $flag)
    {
        return $this->taxHelper->getShippingPrice(
            $rateModel->getPrice(),
            $flag,
            $rateModel->getAddress(),
            $rateModel->getAddress()->getQuote()->getCustomerTaxClassId()
        );
    }

}
