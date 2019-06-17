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
        'Cart2Quote_Quotation/js/quote-checkout/action/place-quote',
        'Cart2Quote_Quotation/js/quote-checkout/action/update-quote',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/model/shipping-service',
        'Magento_Checkout/js/model/quote',
        'Cart2Quote_Quotation/js/quote-checkout/model/email-form-usage-observer',
        'Cart2Quote_Quotation/js/quote-checkout/model/quote-checkout-model-selector',
        'Magento_Customer/js/model/customer'
    ],
    function ($,
              Component,
              ko,
              placeQuoteAction,
              updateQuoteAction,
              setShippingInformationAction,
              shippingService,
              quote,
              emailFormUsageObserver,
              selector,
              customer) {
        'use strict';

        /**
         * A view model for handling the add-to-quote button
         */
        return Component.extend({
            defaults: {
                template: 'Cart2Quote_Quotation/quote-checkout/view/add-to-quote-button'
            },

            /**
             * Flag for checking if the quote is virtual
             */
            isVirtual: quote.isVirtual(),

            /**
             * Flag for to show the fields
             */
            showFields: emailFormUsageObserver.showFields,

            /**
             * Flag for allow to use form
             */
            allowToUseForm: emailFormUsageObserver.allowToUseForm(),

            /**
             * Flag for display shipping options
             */
            displayShippingMethods: emailFormUsageObserver.displayShippingMethods(),

            /**
             * Flag to check if the shipping address is ready for RFQ
             */
            shippingReady: ko.observable(false),

            /**
             * Flag to check if the billing address is ready for RFQ
             */
            billingReady: ko.observable(false),

            /**
             * Flag to check if the quotation fields are ready for RFQ
             */
            quotationReady: ko.observable(false),

            /**
             * Flag for allowing to request a quote
             */
            readyToRequest: null,

            /**
             * Check if the customer is logged in
             */
            isCustomerLoggedIn: customer.isLoggedIn,

            /**
             * Show the login button
             */
            showLoginButton: null,

            /**
             * Show the request button
             */
            showRequestButton: null,

            /**
             * Init component
             */
            initialize: function () {
                this._super();
                var self = this;

                this.initLoginButton();
                this.initRequestButton();

                /** Remove sticky cart summary */
                $('.cart-summary').mage('sticky');

                /** Remove the continue button */
                shippingService.isLoading.subscribe(function () {
                    $('*[data-role="opc-continue"]').remove();
                });

                this.readyToRequest = ko.computed(function () {
                    return (this.shippingReady() && this.billingReady() && this.quotationReady());
                }, this);

                /** Request the quote if the observable readyToRequest is true */
                this.readyToRequest.subscribe(function (readyToRequest) {
                    if (readyToRequest === true) {
                        updateQuoteAction().success(function () {
                            var checkoutAsGuest = false;
                            if (!self.isCustomerLoggedIn() && selector.hasGuestCheckoutFields()) {
                                checkoutAsGuest = !selector.getGuestCheckoutModel().requestAccount();
                            }

                            if (selector.hasBillingAddress()) {
                                placeQuoteAction(
                                    selector.getBillingModel().isAddressSameAsShipping(),
                                    checkoutAsGuest
                                );
                            } else {
                                placeQuoteAction(true, checkoutAsGuest);
                            }

                            /**
                             * Reset the readyToRequest.
                             * This will enable the button the request again.
                             */
                            self.shippingReady(false);
                            self.billingReady(false);
                            self.quotationReady(false);
                        });
                    }
                });
            },

            /**
             * A function to request the quote.
             * If the billing address, shipping address and quotations fields are valid
             * then the quote will be requested.
             */
            validateQuote: function () {
                var requestAccount = false;

                if (selector.hasGuestCheckoutFields()) {
                    requestAccount = selector.getGuestCheckoutModel().requestAccount();
                } else if (this.allowToUseForm && !this.isCustomerLoggedIn()) {
                    requestAccount = true;
                }

                if (requestAccount && selector.hasShippingAddress() || requestAccount && selector.hasBillingAddress()) {
                    this.setDefaultShipping();
                    this.checkShippingAddress();
                    this.checkBillingAddress();
                } else {
                    this.shippingReady(true);
                    this.billingReady(true);
                }

                if (selector.hasQuotationFields() && requestAccount) {
                    /** Copy the names to the guest form to make the form valid */
                    emailFormUsageObserver.copyNamesToGuest();
                }

                this.quotationReady(selector.getQuotationModel().validateFields());
                if (!this.quotationReady()) {
                    this.scrollToError();
                }
            },

            /**
             * Set default cart2quote shipping method to the quote
             * This is required otherwise no shipping address details are set to the quote
             * The shipping is later removed via plugin
             */
            setDefaultShipping: function () {
                if (!this.displayShippingMethods) {
                    quote.shippingMethod({"method_code":"quotation", "carrier_code":"quotation"});
                }
            },

            /**
             * Check if billing address is valid
             *
             * @returns void
             */
            checkBillingAddress: function () {
                if (!selector.getBillingModel().isAddressSameAsShipping()) {
                    selector.getBillingModel().updateAddress();
                    if (!selector.getBillingModel().source.get('params.invalid')) {
                        this.billingReady(true);
                    } else {
                        this.billingReady(false);
                        $("#billing").collapsible("activate");
                        this.scrollToError();
                    }
                } else {
                    var self = this;
                    selector.getBillingModel().updateByShippingAddress().done(function () {
                        self.billingReady(true);
                    });
                }
            },

            /**
             * Check if shipping address is valid
             *
             * @returns void
             */
            checkShippingAddress: function () {
                if (!this.isVirtual) {
                    if (selector.getShippingModel().validateShippingInformation()) {
                        var self = this;
                        setShippingInformationAction().done(function () {
                            self.shippingReady(true);
                        });
                    } else {
                        this.shippingReady(false);
                        $(".checkout-shipping-address").collapsible("activate");
                        if (selector.hasShippingMethod()) {
                            $("#opc-shipping_method").collapsible("activate");
                        }
                        this.scrollToError();
                    }
                } else {
                    this.shippingReady(true);
                }
            },

            /**
             * Scroll the page to the error
             * @return void
             */
            scrollToError: function () {
                var errorElement = $('._error').get(0);
                if (typeof errorElement != undefined) {
                    var offset = $(errorElement).offset();
                    if (typeof offset != 'undefined') {
                        $('html, body').animate({scrollTop: $(errorElement).offset().top}, 500);
                    }

                }
            },

            /**
             * Init the login button
             */
            initLoginButton: function () {
                var self = this;

                self.showLoginButton = ko.computed(function () {
                    return !self.isCustomerLoggedIn() && !self.allowToUseForm
                });
            },

            /**
             * Init the request button
             */
            initRequestButton: function () {
                var self = this;

                self.showRequestButton = ko.computed(function () {
                    return ((self.showFields() && self.allowToUseForm) || (self.isCustomerLoggedIn() && !self.allowToUseForm))
                });
            },

            /**
             * Load login-popup.js using data-mage-init
             */
            setLoginModalEvents: function() {
                $('.login').trigger('contentUpdated');
            }
        });
    }
);
