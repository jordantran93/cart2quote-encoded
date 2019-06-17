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


var config = {
    config:{
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'Cart2Quote_Quotation/js/swatch-renderer':true
            }
        }
    },
    map: {
        "*": {
            quotationAddToCart: 'Cart2Quote_Quotation/js/catalog-add-to-cart',
            productUpdater: 'Cart2Quote_Quotation/js/quote-checkout/view/product-updater',
            loginPopup: 'Cart2Quote_Quotation/js/login-popup',
            movetoquote: 'Cart2Quote_Quotation/js/checkout/cart/movetoquote'
        }
    }
};
