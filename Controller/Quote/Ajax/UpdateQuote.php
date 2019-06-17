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

namespace Cart2Quote\Quotation\Controller\Quote\Ajax;

/**
 * Class UpdateQuote
 *
 * @package Cart2Quote\Quotation\Controller\Quote
 */
class UpdateQuote extends \Cart2Quote\Quotation\Controller\Quote\Ajax\AjaxAbstract
{
    use \Cart2Quote\Features\Traits\Controller\Quote\Ajax\UpdateQuote {
		processAction as private traitProcessAction;
		updateFields as private traitUpdateFields;
	}

	const EVENT_PREFIX = 'update_quote';

    /**
     * Update customer's quote
     *
     * @return void
     */
    public function processAction()
    {
        $this->traitProcessAction();
    }

    /**
     * Update the quotation fields
     *
     * @return void
     */
    private function updateFields()
    {
        $this->traitUpdateFields();
    }
}
