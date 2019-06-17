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
    'mage/translate',
    'jquery/ui'
], function ($, $t) {
    "use strict";

    $.widget('mage.quotationAddToCart', {

        options: {
            quoteFormUrl: false,
            processStart: null,
            processStop: null,
            bindSubmit: true,
            noAjax: true,
            minicartSelector: '[data-block="minicart"]',
            miniquoteSelector: '[data-block="miniquote"]',
            messagesSelector: '[data-placeholder="messages"]',
            productStatusSelector: '.stock.available',

            addToCartButton: {
                selector: '#product-addtocart-button',
                disabledClass: 'disabled',
                textWhileAdding: $t('Adding...'),
                textAdded: $t('Added'),
                textDefault: $t('Add to Cart')
            },

            addToQuoteButton: {
                selector: '#product-addtoquote-button',
                disabledClass: 'disabled',
                textWhileAdding: $t('Adding to Quote...'),
                textAdded: $t('Added'),
                textDefault: $t('Add to Quote')
            }
        },

        _create: function () {
            if (this.options.bindSubmit) {
                this._bindSubmit();
            }
        },

        _bindSubmit: function () {
            var self = this;
            this.element.on('submit', function (e) {
                e.preventDefault();
                self.submitForm($(this));
            });
        },

        isLoaderEnabled: function () {
            return this.options.processStart && this.options.processStop;
        },

        submitForm: function (form) {
            var self = this;
            if (form.has('input[type="file"]').length && form.find('input[type="file"]').val() !== '' && self.options.noAjax) {
                self.element.off('submit');

                // Check if quote is being requested.
                if (self.usingQuote()) {
                    form.attr('action', self.options.quoteFormUrl);
                }

                form.submit();
            } else {
                self.ajaxSubmit(form);
            }
        },

        ajaxSubmit: function (form) {
            var self = this;
            var action = form.attr('action');

            // Check if quote is being requested.
            if (self.usingQuote()) {
                self.disableButton(form, self.options.addToCartButton, false);
                self.disableButton(form, self.options.addToQuoteButton, true);
                $(self.options.miniquoteSelector).trigger('contentLoading');
                action = self.options.quoteFormUrl;
            } else {
                self.disableButton(form, self.options.addToCartButton, true);
                self.disableButton(form, self.options.addToQuoteButton, false);
                $(self.options.minicartSelector).trigger('contentLoading');
            }

            $.ajax({
                url: action,
                data: form.serialize(),
                type: 'post',
                dataType: 'json',
                beforeSend: function () {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStart);
                    }
                },
                success: function (res) {
                    if (self.isLoaderEnabled()) {
                        $('body').trigger(self.options.processStop);
                    }

                    if (res.backUrl) {
                        window.location = res.backUrl;
                        return;
                    }
                    if (res.messages) {
                        $(self.options.messagesSelector).html(res.messages);
                    }
                    if (res.minicart) {
                        if (self.usingQuote()) {
                            $(self.options.miniquoteSelector).replaceWith(res.minicart);
                            $(self.options.miniquoteSelector).trigger('contentUpdated');
                        } else {
                            $(self.options.minicartSelector).replaceWith(res.minicart);
                            $(self.options.minicartSelector).trigger('contentUpdated');
                        }

                    }
                    if (res.product && res.product.statusText) {
                        $(self.options.productStatusSelector)
                            .removeClass('available')
                            .addClass('unavailable')
                            .find('span')
                            .html(res.product.statusText);
                    }

                    if (self.usingQuote()) {
                        self.enableButton(form, self.options.addToCartButton, false);
                        self.enableButton(form, self.options.addToQuoteButton, true);
                    } else {
                        self.enableButton(form, self.options.addToCartButton, true);
                        self.enableButton(form, self.options.addToQuoteButton, false);
                    }

                }
            });
        },

        disableButton: function (form, buttonType, useTextWhileAdding) {
            var button = $(form).find(buttonType.selector);
            button.addClass(buttonType.disabledClass);
            if (useTextWhileAdding) {
                button.attr('title', buttonType.textWhileAdding);
                button.find('span').text(buttonType.textWhileAdding);
            }
        },

        enableButton: function (form, buttonType, useTextAdded) {
            var self = this,
                button = $(form).find(buttonType.selector);

            if (useTextAdded) {
                button.find('span').text(buttonType.textAdded);
                button.attr('title', buttonType.textAdded);
            }

            setTimeout(function () {
                button.removeClass(buttonType.disabledClass);
                button.find('span').text(buttonType.textDefault);
                button.attr('title', buttonType.textDefault);
            }, 1000);
        },

        /**
         * Checks if requesting a quote.
         * @returns {boolean}
         */
        usingQuote: function () {
            if (this.options.quoteFormUrl !== false) {
                return true;
            } else {
                return false;
            }
        }
    });

    return $.mage.quotationAddToCart;
});
