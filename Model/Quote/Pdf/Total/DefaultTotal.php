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

namespace Cart2Quote\Quotation\Model\Quote\Pdf\Total;

/**
 * Sales Order Total PDF model
 */
class DefaultTotal extends \Magento\Sales\Model\Order\Pdf\Total\DefaultTotal
{
    use \Cart2Quote\Features\Traits\Model\Quote\Pdf\Total\DefaultTotal {
		getTotalsForDisplay as private traitGetTotalsForDisplay;
		getFullTaxInfo as private traitGetFullTaxInfo;
		appendEmptyRows as private traitAppendEmptyRows;
	}

	/**
     * Get total for display on PDF
     * @return array
     */
    public function getTotalsForDisplay()
    {
        return $this->traitGetTotalsForDisplay();
    }

    /**
     * Get array of arrays with tax information for display in PDF
     * array(
     *  $index => array(
     *      'amount'   => $amount,
     *      'label'    => $label,
     *      'font_size'=> $font_size
     *  )
     * )
     *
     * @return array
     */
    public function getFullTaxInfo()
    {
        return $this->traitGetFullTaxInfo();
    }

    /**
     * Append empty row beneath current total
     *
     * @param $totals
     * @param $amount
     * @return array
     */
    public function appendEmptyRows($totals, $amount)
    {
        return $this->traitAppendEmptyRows($totals, $amount);
    }
}
