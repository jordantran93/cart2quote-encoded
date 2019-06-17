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

namespace Cart2Quote\Quotation\Model\Quote\Pdf\Items;

/**
 * Quote Pdf Items renderer Abstract
 */
abstract class AbstractItems extends \Magento\Sales\Model\Order\Pdf\Items\AbstractItems
{
    use \Cart2Quote\Features\Traits\Model\Quote\Pdf\Items\AbstractItems {
		setQuote as private traitSetQuote;
		getQuote as private traitGetQuote;
		getQuoteTierItemPricesForDisplay as private traitGetQuoteTierItemPricesForDisplay;
	}

	/**
     * Core string
     *
     * @var \Magento\Framework\Stdlib\StringUtils
     */
    protected $string;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    protected $quote;

    /**
     * Set Quote model
     *
     * @param  \Cart2Quote\Quotation\Model\Quote
     * @return $this
     */
    public function setQuote(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        return $this->traitSetQuote($quote);
    }

    /**
     * Retrieve quote object
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getQuote()
    {
        return $this->traitGetQuote();
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuoteTierItemPricesForDisplay()
    {
        return $this->traitGetQuoteTierItemPricesForDisplay();
    }
}
