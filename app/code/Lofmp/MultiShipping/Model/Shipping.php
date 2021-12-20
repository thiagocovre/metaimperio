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

namespace Lofmp\MultiShipping\Model;

use Lof\MarketPlace\Helper\Seller;
use Magento\Framework\App\ObjectManager;
use Magento\Shipping\Model\Rate\PackageResultFactory;

class Shipping extends \Magento\Shipping\Model\Shipping
{
    const SEPARATOR = ' ';

    const METHOD_SEPARATOR = ':';

    protected $_objectManager;
    protected $_register;
    protected $_request;
    protected $sellerHelper;
    protected $sellerFactory;
    protected $product;
    protected $_helper;
    protected $helperData;

    public function __construct(
        ?PackageResultFactory $packageResultFactory = null,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\Config $shippingConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Shipping\Model\CarrierFactory $carrierFactory,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Shipping\Model\Shipment\RequestFactory $shipmentRequestFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        \Magento\Framework\Math\Division $mathDivision,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        \Lof\MarketPlace\Model\SellerFactory $sellerFactory,
        \Magento\Catalog\Model\ProductFactory $product,
        \Lof\MarketPlace\Helper\Data $helperData,
        Seller $sellerHelper,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        parent::__construct($scopeConfig, $shippingConfig, $storeManager, $carrierFactory, $rateResultFactory, $shipmentRequestFactory, $regionFactory, $mathDivision, $stockRegistry);
        $this->packageResultFactory = $packageResultFactory
            ?? ObjectManager::getInstance()->get(PackageResultFactory::class);
        $this->_request = $request;
        $this->sellerHelper = $sellerHelper;
        $this->helperData = $helperData;
        $this->sellerFactory = $sellerFactory;
        $this->product = $product;
        $this->_objectManager = $objectInterface;
        $this->_helper = $this->_objectManager->get('Lofmp\MultiShipping\Helper\Data');
        $this->_register = $this->_objectManager->get('Magento\Framework\Registry');
    }

    public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
        $quotes = array();
        $sellerAddressDetails = array();

        foreach ($request->getAllItems() as $k => $item) {
            if ($this->sellerHelper->getSellerIdByProduct($item->getProduct()->getId())) {
                $sellerId = $this->sellerHelper->getSellerIdByProduct($item->getProduct()->getId());
                $seller = $this->sellerFactory->create()->load($sellerId);
                if ($seller && $seller->getId()) {
                    $this->_register->register('current_order_seller', $seller);
                }
                if (isset($sellerAddressDetails[$sellerId]) && count($sellerAddressDetails[$sellerId]) > 0
                ) {
                    $sellerAddress = $sellerAddressDetails[$sellerId];
                } else {
                    $sellerAddress = $this->_helper->getSellerAddress($sellerId);
                }
                if ($this->_helper->validateAddress($sellerAddress)
                ) {
                    if (!isset($quotes[$sellerId])) {
                        $quotes[$sellerId] = array();
                    }
                    $quotes[$sellerId][] = $item;
                    if (!isset($sellerAddressDetails[$sellerId])) {
                        $sellerAddressDetails[$sellerId] = $sellerAddress;
                    }
                }
                if ($this->_register->registry('current_order_seller') != null) {
                    $this->_register->unregister('current_order_seller');
                }
            } else {
                $quotes['admin'][] = $item;
            }
        }

        if ($this->_register->registry('current_order_seller') != null) {
            $this->_register->unregister('current_order_seller');
        }
        $origRequest = clone $request;
        $last_count = 0;
        $prod_model = $this->product->create();
        if ($this->_objectManager->get('Magento\Checkout\Model\Session')->getInvalidItem()) {
            $this->_objectManager->get('Magento\Checkout\Model\Session')->unsInvalidItem();
        }

        foreach ($quotes as $sellerId => $items) {
            $request = clone $origRequest;
            $request->setSellerId($sellerId);
            $request->setSellerItems($items);
            $request->setAllItems($items);
            $request->setPackageWeight($this->getItemWeight($request, $items));
            $request->setPackageQty($this->getItemQty($request, $items));
            $request->setPackageValue($this->getItemSubtotal($request, $items));
            $request->setBaseSubtotalInclTax($this->getItemSubtotal($request, $items));

            //set address for seller
            if ($sellerId != 'admin') {
                $seller = $this->sellerFactory->create()->load($sellerId);
                if ($seller && $seller->getId()) {
                    $this->_register->register('current_order_seller', $seller);
                }
                $sellerAddress = $sellerAddressDetails[$sellerId];
                if (isset($sellerAddress['country_id'])) {
                    $request->setOrigCountry($sellerAddress['country_id']);
                }
                if (isset($sellerAddress['region'])) {
                    $request->setOrigRegionCode($sellerAddress['region']);
                }
                if (isset($sellerAddress['region_id'])) {
                    $origRegionCode = $sellerAddress['region_id'];
                    if (is_numeric($origRegionCode)) {
                        $origRegionCode = $this->_objectManager->get('Magento\Directory\Model\Region')->load($origRegionCode)->getCode();
                    }
                    $request->setOrigRegionCode($origRegionCode);
                }
                if (isset($sellerAddress['postcode'])) {
                    $request->setOrigPostcode($sellerAddress['postcode']);
                }
                if (isset($sellerAddress['city'])) {
                    $request->setOrigCity($sellerAddress['city']);
                }
            }
            $storeId = $request->getStoreId();
            if (!$request->getOrig()) {
                $request
                    ->setCountryId($this->helperData->getStoreConfig(\Magento\Shipping\Model\Config::XML_PATH_ORIGIN_COUNTRY_ID, $storeId))
                    ->setRegionId($this->helperData->getStoreConfig(\Magento\Shipping\Model\Config::XML_PATH_ORIGIN_REGION_ID, $storeId))
                    ->setCity($this->helperData->getStoreConfig(\Magento\Shipping\Model\Config::XML_PATH_ORIGIN_CITY, $storeId))
                    ->setPostcode($this->_objectManager->create('Lof\MarketPlace\Helper\Data')->getStoreConfig(\Magento\Shipping\Model\Config::XML_PATH_ORIGIN_POSTCODE, $storeId));
            }
            $limitCarrier = $request->getLimitCarrier();
            if (!$limitCarrier) {
                $carriers = $this->helperData->getStoreConfig('carriers', $storeId);
                foreach ($carriers as $carrierCode => $carrierConfig) {
                    $this->collectCarrierRates($carrierCode, $request);
                }
            } else {
                if (!is_array($limitCarrier)) {
                    $limitCarrier = array($limitCarrier);
                }
                foreach ($limitCarrier as $carrierCode) {
                    $carrierConfig = $this->helperData->getStoreConfig('carriers/' . $carrierCode, $storeId);
                    if (!$carrierConfig) {
                        continue;
                    }
                    $this->collectCarrierRates($carrierCode, $request);
                }
            }
            if ($this->_register->registry('current_order_seller') != null) {
                $this->_register->unregister('current_order_seller');
            }
            $total_count = count($this->getResult()->getAllRates());
            $current_count = $total_count - $last_count;
            $last_count = $total_count;
            if ($current_count < 1) {
                $prod_name = $this->_objectManager->get('Magento\Checkout\Model\Session')->getInvalidItem();
                foreach ($items as $item) {
                    $prod_name[] = $prod_model->load($item->getProductId())->getName();
                }
                $this->_objectManager->get('Magento\Checkout\Model\Session')->setInvalidItem($prod_name);
            }
        }
        $shippingRates = $this->getResult()->getAllRates();
        $newRates = array();
        $newSellerRates = array();
        foreach ($this->ratesBySeller($shippingRates, $quotes) as $sellerId => $rates) {
            if(!sizeof($newSellerRates)) {
                foreach($rates as $rate){
                    $newSellerRates[$rate->getCarrier().'_'.$rate->getMethod()] = $rate->getPrice();
                }
            }else{
                $tmpRates = array();
                foreach($rates as $rate){
                    foreach($newSellerRates as $code => $shippingPrice){
                        $tmpRates[$code.self::METHOD_SEPARATOR.$rate->getCarrier().'_'.$rate->getMethod()] = $shippingPrice + $rate->getPrice();
                    }
                }
                $newSellerRates = $tmpRates;
            }
            foreach ($rates as $rate) {
                $newRates[$sellerId.'|'.$rate->getCarrier().'_'.$rate->getMethod()]['price'] = $rate->getPrice();
                $newRates[$sellerId.'|'.$rate->getCarrier().'_'.$rate->getMethod()]['method_title'] = $rate->getMethodTitle();
            }
            $SellerRates = $newRates;
        }
        foreach ($newSellerRates as $code => $shipping) {
            $method = $this->_objectManager->create('Magento\Quote\Model\Quote\Address\RateResult\Method');
            $method->setCarrier('seller_rates');
            $carrier_title = $this->helperData->getStoreConfig('lofmp_multishipping/general/carrier_title', $storeId);
            $method->setCarrierTitle(__($carrier_title));
            $method->setMethod($code);
            $method_title = $this->_objectManager->get('Lof\MarketPlace\Helper\Data')->getStoreConfig('lofmp_multishipping/general/method_title', $storeId);
            $method->setMethodTitle(__($method_title));
            $method->setPrice($shipping);
            $method->setCost($shipping);
            $this->getResult()->append($method);
        }
        foreach ($SellerRates as $code => $shipping) {
            if(!$shipping['method_title'] && !$shipping['price']) {
                continue;
            }
            $method = $this->_objectManager->create('Magento\Quote\Model\Quote\Address\RateResult\Method');
            $method->setCarrier('seller_rates');
            $carrier_title = $this->helperData->getStoreConfig('lofmp_multishipping/general/carrier_title', $storeId);
            $method->setCarrierTitle(__($carrier_title));
            $method->setMethod($code);
            $method->setMethodTitle(__($shipping['method_title']));
            $method->setPrice($shipping['price']);
            $method->setCost($shipping['price']);
            $this->getResult()->append($method);
        }
        return $this;
    }

    /**
     * Group shipping rates by each seller.
     *
     * @param unknown $shippingRates
     */
    public function ratesBySeller($shippingRates, $quotes)
    {
        $rates = array();
        foreach ($shippingRates as $rate) {
            if (!$rate->getSellerId()) {
                $rate->setSellerId("admin");
            }
            if (!isset($rates[$rate->getSellerId()])) {
                $rates[$rate->getSellerId()] = array();
            }
            $rates[$rate->getSellerId()][] = $rate;
        }
        $this->_helper->getActiveSellerMethods();
        ksort($rates);

        return $rates;
    }
    public function collectCarrierRates($carrierCode, $request)
    {
        try {
            $carrier = $this->prepareCarrier($carrierCode, $request);
        } catch (\RuntimeException $exception) {
            return $this;
        }

        /** @var Result|\Magento\Quote\Model\Quote\Address\RateResult\Error|null $result */
        $result = null;
        if ($carrier->getConfigData('shipment_requesttype')) {
            $packages = $this->composePackagesForCarrier($carrier, $request);
            if (!empty($packages)) {
                //Multiple shipments
                /** @var PackageResult $result */
                $result = $this->packageResultFactory->create();
                foreach ($packages as $weight => $packageCount) {
                    $request->setPackageWeight($weight);
                    $packageResult = $carrier->collectRates($request);
                    if (!$packageResult) {
                        return $this;
                    } else {
                        $result->appendPackageResult($packageResult, $packageCount);
                    }
                }
            }
        }
        if (!$result) {
            //One shipment for all items.
            $result = $carrier->collectRates($request);
        }
        if($result && $request->getSellerId() && $result->getAllRates()) {
            foreach ($result->getAllRates() as $rate) {
                $rate->setSellerId($request->getSellerId());
            }
        }
        if (!$result) {
            return $this;
        } elseif ($result instanceof Result) {
            $this->getResult()->appendResult($result, $carrier->getConfigData('showmethod') != 0);
        } else {
            $this->getResult()->append($result);
        }

        return $this;
    }
    /**
     * Retrieve item quantity by id
     *
     * @param int $itemId
     * @return float|int
     */
    public function getItemQty($request, $items)
    {
        $qty = 0;
        foreach ($items as $item) {
            $qty += $item->getQty();
        }
        return $qty;
    }

    /**
     * Retrieve item quantity by id
     *
     * @param int $itemId
     * @return float|int
     */
    public function getItemWeight($request, $items)
    {
        $qty = 0;
        foreach ($items as $item) {
            if($item->getData('product_type') != 'configurable' && $item->getData('product_type') != 'bundle') {
                $qty += $item->getQty() * $item->getWeight();
            }
        }
        return $qty;
    }


    /**
     * Retrieve item Base subtotal by id
     *
     * @param int $itemId
     * @return float|int
     */
    public function getItemSubtotal($request, $items)
    {
        $row_total = 0;
        foreach ($items as $item) {
            $row_total += $item->getBaseRowTotalInclTax();
        }
        return $row_total;
    }
    /**
     * Prepare carrier to find rates.
     *
     * @param string $carrierCode
     * @param RateRequest $request
     * @return AbstractCarrier
     * @throws \RuntimeException
     */
    private function prepareCarrier(string $carrierCode, \Magento\Quote\Model\Quote\Address\RateRequest $request): \Magento\Shipping\Model\Carrier\AbstractCarrier
    {
        $carrier = $this->isShippingCarrierAvailable($carrierCode)
            ? $this->_carrierFactory->create($carrierCode, $request->getStoreId())
            : null;
        if (!$carrier) {
            throw new \RuntimeException('Failed to initialize carrier');
        }
        $carrier->setActiveFlag($this->_availabilityConfigField);
        $result = $carrier->checkAvailableShipCountries($request);
        if (false !== $result && !$result instanceof Error) {
            $result = $carrier->processAdditionalValidation($request);
        }
        if (!$result) {
            /*
             * Result will be false if the admin set not to show the shipping module
             * if the delivery country is not within specific countries
             */
            throw new \RuntimeException('Cannot collect rates for given request');
        } elseif ($result instanceof Error) {
            $this->getResult()->append($result);
            throw new \RuntimeException('Error occurred while preparing a carrier');
        }

        return $carrier;
    }
    /**
     * Checks availability of carrier.
     *
     * @param string $carrierCode
     * @return bool
     */
    private function isShippingCarrierAvailable(string $carrierCode): bool
    {
        return $this->_scopeConfig->isSetFlag(
            'carriers/' . $carrierCode . '/' . $this->_availabilityConfigField,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
