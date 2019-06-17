/*
 *  CART2QUOTE CONFIDENTIAL
 *  __________________
 *  [2009] - [2018] Cart2Quote B.V.
 *  All Rights Reserved.
 *  NOTICE OF LICENSE
 *  All information contained herein is, and remains
 *  the property of Cart2Quote B.V. and its suppliers,
 *  if any.  The intellectual and technical concepts contained
 *  herein are proprietary to Cart2Quote B.V.
 *  and its suppliers and may be covered by European and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Cart2Quote B.V.
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 */
define([
    'jquery',
    'Cart2Quote_Quotation/js/quote-checkout/checkout-data-quotation',
    'Cart2Quote_Quotation/js/quote-checkout/minicart-reload',
    'Cart2Quote_Quotation/js/quote-checkout/action/update-quote',
    'Magento_Checkout/js/model/full-screen-loader'
], function ($, checkoutDataQuotation, minicartReload, updateQuote, fullScreenLoader) {
    "use strict";

    /**
     * Bidding widget for placing a bid on the product detail page.
     */
    $.widget('mage.quotationBiddingUpdate', {

        /**
         * The element options:
         * - Item ID is set in the element
         * - sessionProductKey is the key used on the session
         */
        options: {
            itemId: 0,
            sessionProductKey: undefined
        },

        /**
         * Add all the events on create
         *
         * @private
         */
        _create: function () {
            this.bindInputCheck();
            this.initInputValue();
        },

        /**
         * Update the session JS data on keyup
         */
        bindInputCheck: function () {
            var self = this;
            var data = checkoutDataQuotation.getQuotationProductsFromData();
            var itemId = this.getItemId();

            $(this.element).on('change', function (e) {
                var dataForm = $('#form-validate');
                if (dataForm.validation('isValid')) {
                    self.updateData();
                    self.saveData();
                } else if (data.length !== 0) {
                    $(this).val(data.qty[itemId]);
                } else {
                    $(this).val(this.getAttribute('value'));
                }
            });
        },

        /**
         * Init the input value by loading the value from the checkoutData
         */
        initInputValue: function () {
            var data = checkoutDataQuotation.getQuotationProductsFromData();
            var itemId = this.getItemId();

            if (typeof data !== 'undefined'
                && typeof data[this.options.sessionProductKey] !== 'undefined'
                && typeof data[this.options.sessionProductKey][itemId] !== 'undefined') {
                this.setValue(data[this.options.sessionProductKey][itemId]);
            }

            this.toggleDisabled();
        },

        /**
         * Update the QuotationProducts session data
         */
        updateData: function () {
            var data = checkoutDataQuotation.getQuotationProductsFromData(),
                itemId = this.getItemId(),
                value = this.getValue();

            if (data.length == 0) {
                data = {};
            }

            if (typeof data[this.options.sessionProductKey] === 'undefined') {
                data[this.options.sessionProductKey] = {};
            }

            data[this.options.sessionProductKey][itemId] = value;

            checkoutDataQuotation.setQuotationProductsFromData(data);
        },

        /**
         * Save the new price to the session
         */
        saveData: function () {
            updateQuote().done(function () {
                fullScreenLoader.stopLoader(true);
            });
        },

        /**
         * Get the quote item id
         * @returns {number}
         */
        getItemId: function () {
            return this.options.itemId;
        },

        /**
         * Get the element price
         * @returns {*|jQuery}
         */
        getValue: function () {
            return $(this.element).val();
        },

        /**
         * Set value to the input
         * @param value
         */
        setValue: function (value) {
            $(this.element).val(value);
        },

        /**
         * Toggle disabled
         */
        toggleDisabled: function () {
            $(this.element).prop('disabled', function (i, v) {
                return !v;
            });
        }
    });

    return $.mage.quotationBiddingUpdate;
});
