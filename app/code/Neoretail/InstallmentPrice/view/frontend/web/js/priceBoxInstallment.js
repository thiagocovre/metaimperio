define([
    'jquery',
    'mage/template',
    'mage/translate',
    'Magento_Catalog/js/price-utils'
], function($, mageTemplate, t, untils) {
    'use strict';

    $.widget("mage.priceBoxInstallment", {
        options: {
            priceConfig: null,
            installmentNumber: null,
            productPrice: null,
            priceTemplate: null,
            installmentListMode: false,
            installmentListMinAmount: 0,

            priceToCalcule: null,
        },

        _create: function() {

            this.options.priceToCalcule = this.options.priceConfig.prices ?
                this.options.priceConfig.prices.finalPrice.amount : this.options.productPrice;

            $(this.element).on('updatePrice', this.updatePrice.bind(this));

            $(this.element).trigger('updatePrice', {
                prices: {
                    finalPrice: {
                        amount: 0
                    }
                }
            })
        },

        updatePrice: function(event, pricesRequest){
            var installmentPrice = [];
            for(var i = 1; i <= this.options.installmentNumber; i++){
                var installment = {};
                installment.number = i;
                installment.price = this.calcPrice(pricesRequest.prices.finalPrice.amount, installment.number);

                if(this.isWithinLimit(installment.price)) {
                    installment.price = this.getPriceFormated(installment.price);
                    installmentPrice.push(installment);
                } else {
                    break;
                }
            }

            if(!this.options.installmentListMode) {

                if(installmentPrice.length >= 2) {
                    installmentPrice = installmentPrice[installmentPrice.length - 1];
                    this._renderTemplate(installmentPrice, this.element);
                } else {
                    this._renderTemplateBlank(elem);
                }

            } else {

                var elem = "#installment-price-list-modal";
                if(installmentPrice.length >= 2) {
                    this._renderTemplateList(installmentPrice, elem);
                } else {
                    this._renderTemplateBlank(elem);
                }

            }
        },

        calcPrice: function(extraPrice, installment) {
            var calc = (this.options.priceToCalcule + extraPrice) / installment;
            calc = this.roundUp(calc, 2)
            return calc;
        },

        getPriceFormated: function (price) {
            return untils.formatPrice(price, this.options.priceConfig.priceFormat)
        },

        isWithinLimit: function(price) {
            if(this.options.installmentListMinAmount != 0) {
                return price >= this.options.installmentListMinAmount;
            } else {
                return true;
            }
        },

        _renderTemplate: function(installment, elem){
            var priceTemplate = mageTemplate(this.options.priceTemplate);
            $(elem).html(priceTemplate({
                data: {
                    installment: installment
                }
            }));
        },

        _renderTemplateList: function(installments, elem){
            var priceTemplate = mageTemplate(this.options.priceTemplate);
            $(elem).html(priceTemplate({
                data: installments
            }));
        },

        _renderTemplateBlank: function(elem){
            $(elem).html("");
        },

        /* Arredonda decimal para cima */
        roundUp: function (num, precision) {
            precision = Math.pow(10, precision)
            return Math.round(num * precision) / precision;
        }
    })

    return $.mage.priceBoxInstallment
});
