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

define(
    [
        'jquery',
        'Magento_Ui/js/form/form',
        'ko',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/shipping-service',
        'Cart2Quote_Quotation/js/quote-checkout/checkout-data-quotation',
        'Cart2Quote_Quotation/js/quote-checkout/model/quote-checkout-model-selector',
        'Cart2Quote_Quotation/js/quote-checkout/model/email-form-usage-observer',
        'uiRegistry'
    ],
    function ($,
              Component,
              ko,
              customer,
              shippingService,
              checkoutQuotationData,
              selector,
              emailFormUsage,
              registry) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Cart2Quote_Quotation/quote-checkout/view/guest-checkout'
            },

            loaded: false,
            loginSelector: '#customer-email-fieldset',
            isCustomerLoggedIn: customer.isLoggedIn(),

            showRequestShippingQuote: undefined,
            showRequestShippingQuoteTrigger: undefined,

            /** The toggle variable */
            requestAccount: ko.observable(customer.isLoggedIn()),

            /** Toggle action used in the template */
            toggleRequestAccount: function () {
                this.requestAccount(!this.requestAccount());
            },

            /**
             * Init component
             */
            initialize: function () {
                this._super();

                registry.async('checkoutProvider')(function (checkoutProvider) {
                    var quotationGuestFieldsData = checkoutQuotationData.getQuotationGuestFieldsFromData();

                    if (quotationGuestFieldsData) {
                        checkoutProvider.set(
                            'quotationGuestFieldData',
                            $.extend({}, checkoutProvider.get('quotationGuestFieldData'), quotationGuestFieldsData)
                        );
                    }

                    checkoutProvider.on('quotationGuestFieldData', function (quotationGuestFieldData) {
                        checkoutQuotationData.setQuotationGuestFieldsFromData(quotationGuestFieldData);
                    });
                });
            },

            /**
             * @return {exports.initObservable}
             */
            initObservable: function () {
                this._super();
                var self = this;

                this.initShowRequestShippingQuote();

                /** Subscribe only if the customer is logged in otherwise the checkbox is invisible */
                if (!this.isCustomerLoggedIn) {
                    /** Subscribe to the button switcher */
                    self.requestAccount.subscribe(function (requestAccount) {
                        if (requestAccount) {
                            emailFormUsage.updateFields();
                        } else {
                            emailFormUsage.updateFields();
                            self.showRequestShippingQuote.evaluateImmediate();
                        }
                    });
                }

                /** Hide or show the guest fields based on the customer login */
                shippingService.isLoading.subscribe(function (isLoading) {
                    if (!isLoading && !this.loaded) {
                        this.loaded = true;

                        if (this.isCustomerLoggedIn) {
                            emailFormUsage.updateFields();
                        } else {
                            emailFormUsage.updateFields();
                            this.showRequestShippingQuote.evaluateImmediate();
                        }
                    }
                }, this);

                /**
                 * Request account needs to be true when not using the guest functionality.
                 * You can change the in the Magento store configuration.
                 */
                if (!this.requestAccount()) {
                    this.requestAccount(!this.allowToUseGuest());
                }

                emailFormUsage.showGuestField.subscribe(function () {
                    self.showRequestShippingQuote.evaluateImmediate();
                });

                return this;
            },



            /**
             * Get allow to use guest mode
             * @returns boolean
             */
            allowToUseGuest: function () {
                return Boolean(checkoutQuotationData.getQuotationConfigDataFromData().allowGuest);
            },

            /**
             * Init hide request shipping quote checkbox
             */
            initShowRequestShippingQuote: function () {
                var self = this;

                self.showRequestShippingQuoteTrigger = ko.observable();
                self.showRequestShippingQuote = ko.computed(function () {
                    self.showRequestShippingQuoteTrigger();
                    var passwordVisible = false, email = false;

                    if (selector.hasLoginModel()) {
                        passwordVisible = selector.getLoginModel().isPasswordVisible();
                        email = selector.getLoginModel().validateEmail();
                    }

                    return !self.isCustomerLoggedIn && self.allowToUseGuest() && !passwordVisible && email;
                });

                if (typeof self.showRequestShippingQuote.evaluateImmediate != 'function') {
                    self.showRequestShippingQuote.evaluateImmediate = function () {
                        self.showRequestShippingQuoteTrigger.valueHasMutated();
                    };
                }

                self.showRequestShippingQuote.extend({notify: 'always'});
            }
        });
    }
);
