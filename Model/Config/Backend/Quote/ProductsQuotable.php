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

namespace Cart2Quote\Quotation\Model\Config\Backend\Quote;

/**
 * Backend model for products quotable by default setting
 */
class ProductsQuotable extends \Magento\Eav\Model\Entity\Attribute\Source\Boolean
{
    use \Cart2Quote\Features\Traits\Model\Config\Backend\Quote\ProductsQuotable {
		getAllOptions as private traitGetAllOptions;
		getIndexOptionText as private traitGetIndexOptionText;
	}

	const QUOTABLE = 'cart2quote_quotation/global/quotable';
    /**
     * Add extra option value
     */
    const VALUE_CUSTOMERGROUP = 2;

    /**
     * Retrieve all options array ( rewritten from parent )
     * @return array
     */
    public function getAllOptions()
    {
        return $this->traitGetAllOptions();
    }

    /**
     * Get a text for index option value ( rewritten from parent )
     * @param  string|int $value
     * @return string|bool
     */
    public function getIndexOptionText($value)
    {
        return $this->traitGetIndexOptionText($value);
    }
}
