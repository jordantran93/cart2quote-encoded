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
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('mage.quotationPriceQuoted',
        {
            _create: function () {
                this.init();
            },

            init: function () {
                var self = this;

                $(self.element).change(function (event) {
                    self.priceListener(event);
                });
            },

            priceListener: function (event) {
                var minPrice = parseFloat($(event.target).data("minprice"));

                if (minPrice > 0) {
                    var origPrice = parseFloat(event.target.defaultValue);
                    var newPrice = parseFloat(event.target.value);
                    this.checkCostPrice(newPrice, minPrice, origPrice, event.target);
                }
            },

            checkCostPrice: function (newPrice, minPrice, origPrice, target) {
                if (newPrice < minPrice) {
                    alert($.mage.__('Entered value lower than cost price'));
                    target.value = origPrice;
                }
            }
        });

    return $.mage.quotationPriceQuoted;
});