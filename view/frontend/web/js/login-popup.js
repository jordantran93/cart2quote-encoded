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
        'Magento_Customer/js/model/authentication-popup',
        'mage/url',
        'mage/cookies'
    ],
    function ($, authenticationPopup, url) {
        'use strict';

        return function (config, element) {
            $(element).click(function (event) {
                var date = new Date();
                date.setTime(date.getTime()+420000);
                event.preventDefault();
                $.cookie('login_redirect', url.build('quotation/quote'), {expires : date});
                authenticationPopup.showModal();
                return false;
            });
        };
    }
);
