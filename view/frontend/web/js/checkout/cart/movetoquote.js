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
        'uiComponent',
        'Magento_Ui/js/modal/confirm',
        'Magento_Customer/js/customer-data',
        'mage/url',
        'mage/translate'
    ],
    function ($, Component, confirmation, customerData, url, __) {
        'use strict';

        return Component.extend({
            buttonSelector: null,

            initialize: function () {
                this._super();
                var self = this;
                var cart = customerData.get('cart');
                $(self.buttonSelector).toggle(cart().summary_count > 0);
                cart.subscribe(
                    function (value) {
                        $(self.buttonSelector).toggle(value.summary_count > 0);
                    }
                );
                $(this.buttonSelector).click(function () {
                    confirmation({
                        title: __('Move items to Quote Request'),
                        content: __('Are you sure you want to move the Shopping Cart to the Quote? Your shopping Cart will be cleared.'),
                        actions: {
                            confirm: function () {
                                window.location.href = url.build('quotation/movetoquote');
                            }
                        }
                    })
                });
            },
        });

    });