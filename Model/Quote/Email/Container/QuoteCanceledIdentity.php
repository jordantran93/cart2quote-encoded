<?php
/**
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

namespace Cart2Quote\Quotation\Model\Quote\Email\Container;

/**
 * Class QuoteCanceledIdentity
 * @package Cart2Quote\Quotation\Model\Quote\Email\Container
 */
class QuoteCanceledIdentity extends AbstractQuoteIdentity
{
    use \Cart2Quote\Features\Traits\Model\Quote\Email\Container\QuoteCanceledIdentity {
	}

	/**
     * Configuration paths
     */
    const XML_PATH_EMAIL_COPY_METHOD = 'cart2quote_email/quote_canceled/copy_method';
    const XML_PATH_EMAIL_COPY_TO = 'cart2quote_email/quote_canceled/copy_to';
    const XML_PATH_EMAIL_IDENTITY = 'cart2quote_email/quote_canceled/identity';
    const XML_PATH_EMAIL_TEMPLATE = 'cart2quote_email/quote_canceled/template';
    const XML_PATH_EMAIL_ENABLED = 'cart2quote_email/quote_canceled/enabled';
}
