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

define(
    [
        'ko',
        'underscore',
        'uiComponent',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Catalog/js/price-utils',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/select-shipping-method',
        'Magento_Checkout/js/checkout-data'
    ],
    function (
        ko,
        _,
        Component,
        shippingService,
        priceUtils,
        quote,
        selectShippingMethodAction,
        checkoutData
    ) {
        'use strict';
        return Component.extend(
            {
                defaults: {
                    template: 'Lofmp_MultiShipping/cart/shipping-rates'
                },
                isVisible: ko.observable(!quote.isVirtual()),
                isLoading: shippingService.isLoading,
                shippingRates: shippingService.getShippingRates(),
                shippingRateGroups: ko.observableArray([]),
                selectedShippingMethod: ko.computed(
                    function () {
                        var seletecdmth = quote.shippingMethod() ? quote.shippingMethod().method_code : null;    
                        if(seletecdmth) {
                            var METHOD_SEPARATOR = ':';
                            var methods = seletecdmth.split(METHOD_SEPARATOR);
                            for(var i = 0; i < methods.length; i ++){
                                if(document.getElementById(methods[i]) && document.getElementById('seller_rates_'+seletecdmth)) {
                                    document.getElementById(methods[i]).checked = true;                    
                                }
                            }
                        }
                        var inputs = document.getElementsByClassName('radio');
                        for(var i = 0; i < inputs.length; i++) {
                            inputs[i].disabled = false;
                        }
                        return quote.shippingMethod() ? quote.shippingMethod()['carrier_code'] + '_' + quote.shippingMethod()['method_code'] : null;
                    } 
                ),

                /**
             * @override
             */
                initObservable: function () {
                    var self = this;
                    this._super();

                    this.shippingRates.subscribe(
                        function (rates) {
                            self.shippingRateGroups([]);
                            _.each(
                                rates, function (rate) {
                                    var carrierTitle = rate['carrier_title'];

                                    if (self.shippingRateGroups.indexOf(carrierTitle) === -1) {
                                        self.shippingRateGroups.push(carrierTitle);
                                    }
                                }
                            );
                        }
                    );
                    return this;
                },

                /**
             * Get shipping rates for specific group based on title.
             *
             * @returns Array
             */
                getRatesForGroup: function (shippingRateGroupTitle) {
                    return _.filter(
                        this.shippingRates(), function (rate) {
                            return shippingRateGroupTitle === rate['carrier_title'];
                        }
                    );
                },

                /**
             * Format shipping price.
             *
             * @returns {String}
             */
                getFormattedPrice: function (price) {
                    return priceUtils.formatPrice(price, quote.getPriceFormat());
                },

                /**
             * Set shipping method.
             *
             * @param   {String} methodData
             * @returns bool
             */
                selectShippingMethod: function (methodData) {
                    selectShippingMethodAction(methodData);
                    checkoutData.setSelectedShippingRate(methodData['carrier_code'] + '_' + methodData['method_code']);
                    return true;
                },
            
                selectVirtualMethod: function(methodData){
                    var flagg = true;
                    var METHOD_SEPARATOR = ':';
                    var SEPARATOR = '~';
                    var rates = new Array();
                    var sortedrate = new Array();
                    jQuery('.seller-rates').each(
                        function(indx,elm){
                            var flag = false;
                            jQuery(elm).find('.radio').each(
                                function(i,inpt){                    
                                    if(inpt.checked) {
                                        flag = true;                                                    
                                        rates.push(inpt.value);                           
                                    }
                                }
                            );
                            if(!flag) {
                                flagg = false;
                            }                        
                        }
                    );
                    if(flagg) {
                        for(var i = 0; i < rates.length; i ++){
                            var sortedValue = rates[i].split(SEPARATOR);
                            var pos = isNaN(parseInt(sortedValue[1])) ? 0 : parseInt(sortedValue[1]);                            
                            sortedrate[pos] = rates[i];
                        }
                        var rate = '';
                        for(var i=0;i< sortedrate.length;i++){            
                            if(sortedrate[i]!=undefined) {
                                if(rate) {                         
                                    rate = rate + METHOD_SEPARATOR + sortedrate[i]; 
                                }else{
                                    rate =  sortedrate[i]; 
                                }
                            }                 
                        }    
                        if(document.getElementById('seller_rates_'+rate)) {
                            var event = new Event('click');
                            document.getElementById('seller_rates_'+rate).dispatchEvent(event);
                        }                
                    }
                    return true;
                }
            }
        );
    }
);
