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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote\Collection;

/**
 * Flat quotation quote collection
 */
abstract class AbstractCollection extends \Cart2Quote\Quotation\Model\ResourceModel\Collection\AbstractCollection
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\Collection\AbstractCollection {
		getQuotationQuote as private traitGetQuotationQuote;
		setQuotationQuote as private traitSetQuotationQuote;
		setQuoteFilter as private traitSetQuoteFilter;
	}

	/**
     * Order object
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    protected $_quotationQuote = null;

    /**
     * Order field for setOrderFilter
     * @var string
     */
    protected $_quoteField = 'parent_id';

    /**
     * Retrieve quotation quote as parent collection object
     * @return \Cart2Quote\Quotation\Model\Quote|null
     */
    public function getQuotationQuote()
    {
        return $this->traitGetQuotationQuote();
    }

    /**
     * Set quotation quote model as parent collection object
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return $this
     */
    public function setQuotationQuote($quote)
    {
        return $this->traitSetQuotationQuote($quote);
    }

    /**
     * Add quote filter
     * @param int|\Cart2Quote\Quotation\Model\Quote $quote
     * @return $this
     */
    public function setQuoteFilter($quote)
    {
        return $this->traitSetQuoteFilter($quote);
    }
}
