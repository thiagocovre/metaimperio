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

/*global define*/
define(
    [
        'jquery',
        "underscore",
        'Magento_Ui/js/form/form',
        'ko',
        'Magento_Customer/js/model/customer',
        'Magento_Customer/js/model/address-list',
        'Magento_Checkout/js/model/address-converter',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/action/create-shipping-address',
        'Magento_Checkout/js/action/select-shipping-address',
        'Magento_Checkout/js/model/shipping-rates-validator',
        'Magento_Checkout/js/model/shipping-address/form-popup-state',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Checkout/js/action/select-shipping-method',
        'Magento_Checkout/js/model/shipping-rate-registry',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Ui/js/modal/modal',
        'Magento_Checkout/js/model/checkout-data-resolver',
        'Magento_Checkout/js/checkout-data',
        'uiRegistry',
        'Magento_Catalog/js/price-utils',
        'mage/translate',        
        'Magento_Checkout/js/model/shipping-rate-service'
    ],
    function(
        $,
        _,
        Component,
        ko,
        customer,
        addressList,
        addressConverter,
        quote,
        createShippingAddress,
        selectShippingAddress,
        shippingRatesValidator,
        formPopUpState,
        shippingService,
        selectShippingMethodAction,
        rateRegistry,
        setShippingInformationAction,
        stepNavigator,
        modal,
        checkoutDataResolver,
        checkoutData,
        registry,
        priceUtils,
        $t
    ) {
        'use strict';
        var popUp = null;
        return Component.extend(
            {
                defaults: {
                    template: 'Lofmp_MultiShipping/shipping'
                },
                visible: ko.observable(!quote.isVirtual()),
                errorValidationMessage: ko.observable(false),
                isCustomerLoggedIn: customer.isLoggedIn,
                isFormPopUpVisible: formPopUpState.isVisible,
                isFormInline: addressList().length == 0,
                isNewAddressAdded: ko.observable(false),
                saveInAddressBook: 1,
                quoteIsVirtual: quote.isVirtual(),

                initialize: function () {
                	console.log('initialize');
                    var self = this;
                    this._super();
                    if (!quote.isVirtual()) {
                        stepNavigator.registerStep(
                            'shipping',
                            '',
                            'Shipping',
                            this.visible, _.bind(this.navigate, this),
                            10
                        );
                    }
                    checkoutDataResolver.resolveShippingAddress();

                    var hasNewAddress = addressList.some(
                        function (address) {
                            return address.getType() == 'new-customer-address';
                        }
                    );

                    this.isNewAddressAdded(hasNewAddress);

                    this.isFormPopUpVisible.subscribe(
                        function (value) {
                            if (value) {
                                self.getPopUp().openModal();
                            }
                        }
                    );

                    quote.shippingMethod.subscribe(
                        function (value) {
                            self.errorValidationMessage(false);
                        }
                    );

                    registry.async('checkoutProvider')(function (checkoutProvider) {
                        var shippingAddressData = checkoutData.getShippingAddressFromData();
                        if (shippingAddressData) {
                            checkoutProvider.set(
                                'shippingAddress',
                                $.extend({}, checkoutProvider.get('shippingAddress'), shippingAddressData)
                            );
                        }
                        checkoutProvider.on(
                            'shippingAddress', function (shippingAddressData) {
                                checkoutData.setShippingAddressFromData(shippingAddressData);
                            }
                        );
                    });
        
                    this.rates.subscribe(
                        function (grates) {
                            self.shippingRateGroups([]);
                            _.each(
                                grates, function (rate) {
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

                navigate: function () {
                	console.log('navigate');
                    //load data from server for shipping step
                },

                initElement: function(element) {
                	console.log('initElement');
                    if (element.index === 'shipping-address-fieldset') {
                        shippingRatesValidator.bindChangeHandlers(element.elems(), false);
                    }
                },

                getPopUp: function() {
                	console.log('getPopUp');
                    var self = this;
                    if (!popUp) {
                        var buttons = this.popUpForm.options.buttons;
                        this.popUpForm.options.buttons = [
                        {
                            text: buttons.save.text ? buttons.save.text : $t('Save Address'),
                            class: buttons.save.class ? buttons.save.class : 'action primary action-save-address',
                            click: self.saveNewAddress.bind(self)
                        },
                        {
                            text: buttons.cancel.text ? buttons.cancel.text: $t('Cancel'),
                            class: buttons.cancel.class ? buttons.cancel.class : 'action secondary action-hide-popup',
                            click: function() {
                                this.closeModal();
                            }
                        }
                        ];
                        this.popUpForm.options.closed = function() {
                            self.isFormPopUpVisible(false);
                        };
                        popUp = modal(this.popUpForm.options, $(this.popUpForm.element));
                    }
                    return popUp;
                },

                /**
            * Show address form popup 
            */
                showFormPopUp: function() {
                	console.log('showFormPopUp');
                    this.isFormPopUpVisible(true);
                },


                /**
            * Save new shipping address 
            */
                saveNewAddress: function() {
                	console.log('saveNewAddress');
                    this.source.set('params.invalid', false);
                    this.source.trigger('shippingAddress.data.validate');

                    if (!this.source.get('params.invalid')) {
                        var addressData = this.source.get('shippingAddress');
                        addressData.save_in_address_book = this.saveInAddressBook;

                        // New address must be selected as a shipping address
                        var newShippingAddress = createShippingAddress(addressData);
                        selectShippingAddress(newShippingAddress);
                        checkoutData.setSelectedShippingAddress(newShippingAddress.getKey());
                        checkoutData.setNewCustomerShippingAddress(addressData);
                        this.getPopUp().closeModal();
                        this.isNewAddressAdded(true);
                    }
                },

                /**
            * Shipping Method View 
            **/
                rates: shippingService.getShippingRates(),
                shippingRateGroups: ko.observableArray([]),
                isLoading: shippingService.isLoading,
                isSelected: ko.computed(
                    function () {                    

                        return quote.shippingMethod() ? quote.shippingMethod().carrier_code + '_' + quote.shippingMethod().method_code : null;
                    }
                ),

                getFormattedPrice: function (price) {
                    return priceUtils.formatPrice(price, quote.getPriceFormat());
                },
            
                getRatesForGroup: function (shippingRateGroupTitle) {
                    return _.filter(
                        this.rates(), function (rate) {
                            return shippingRateGroupTitle === rate['carrier_title'];
                        }
                    );
                },
                                    
                selectShippingMethod: function(shippingMethod) {
                    selectShippingMethodAction(shippingMethod);
                    checkoutData.setSelectedShippingRate(shippingMethod.carrier_code + '_' + shippingMethod.method_code);
                    return true;
                },
            
                selectVirtualMethod: function(shippingMethod) {
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
                        if(document.getElementById('s_method_seller_rates_'+rate)) {
                            var event = new Event('click');
                            document.getElementById('s_method_seller_rates_'+rate).dispatchEvent(event);
                        }        
                    }
                    return true;
                },

                setShippingInformation: function () {
                	console.log('setShippingInformation');
                    if (this.validateShippingInformation()) {
                        setShippingInformationAction().done(
                            function() {
                                stepNavigator.next();
                            }
                        );
                    }
                },

                validateShippingInformation: function () {
                	console.log('validateShippingInformation');
                    var shippingAddress,
                    addressData,
                    loginFormSelector = 'form[data-role=email-with-possible-login]',
                    emailValidationResult = customer.isLoggedIn();

                    if (!quote.shippingMethod()) {
                        this.errorValidationMessage('Please specify a shipping method.');
                        return false;
                    }

                    if (!customer.isLoggedIn()) {
                        $(loginFormSelector).validation();
                        emailValidationResult = Boolean($(loginFormSelector + ' input[name=username]').valid());
                    }

                    if (!emailValidationResult) {
                        $(loginFormSelector + ' input[name=username]').focus();
                    }

                    if (this.isFormInline) {
                        this.source.set('params.invalid', false);
                        this.source.trigger('shippingAddress.data.validate');
                        if (this.source.get('shippingAddress.custom_attributes')) {
                            this.source.trigger('shippingAddress.custom_attributes.data.validate');
                        };
                        if (this.source.get('params.invalid')
                            || !quote.shippingMethod().method_code
                            || !quote.shippingMethod().carrier_code
                            || !emailValidationResult
                        ) {
                            return false;
                        }
                        shippingAddress = quote.shippingAddress();
                        addressData = addressConverter.formAddressDataToQuoteAddress(
                            this.source.get('shippingAddress')
                        );

                        //Copy form data to quote shipping address object
                        for (var field in addressData) {
                            if (addressData.hasOwnProperty(field)
                                && shippingAddress.hasOwnProperty(field)
                                && typeof addressData[field] != 'function'
                            ) {
                                shippingAddress[field] = addressData[field];
                            }
                        }

                        if (customer.isLoggedIn()) {
                            shippingAddress.save_in_address_book = 1;
                        }
                        selectShippingAddress(shippingAddress);
                    }
                    return true;
                }
            }
        );
    }
);
