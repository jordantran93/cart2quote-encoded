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
    'ko',
    'Magento_Checkout/js/view/form/element/email',
    'Cart2Quote_Quotation/js/quote-checkout/model/email-form-usage-observer'
], function ($, ko, Component, emailFormUsageObserver) {
    'use strict';

        return Component.extend({
            defaults: {
                listens: {
                    isPasswordVisible: 'passwordVisibleChanged'
                }
            },

            showGuestText: ko.observable(false),
            showPasswordField: ko.observable(false),

            /**
             * Initializes observable properties of instance
             *
             * @returns {Object} Chainable.
             */
            initObservable: function () {
                this._super();
                this.passwordVisibleChanged();

                return this;
            },

            /**
             * Update showGuestText and showPasswordField each time isPasswordVisible is changed
             */
            passwordVisibleChanged: function () {
                var requireLogin = emailFormUsageObserver.registeredQuoteCheckoutMode() == "0";
                this.showGuestText(this.isPasswordVisible() && !requireLogin);
                this.showPasswordField(this.isPasswordVisible() && requireLogin);
            }
        });
    }
);
