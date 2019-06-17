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

namespace Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\Columns;

/**
 * Class PriceQuoted
 *
 * @package Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\Columns
 */
class PriceQuoted extends \Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\DefaultRenderer
{
    /**
     * Checks if negative profit is allowed. If true, negative profit is not allowed.
     * @return boolean
     */
    private function isDisabledNegativeProfit()
    {
        return $this->_scopeConfig->getValue(
            'cart2quote_advanced/negativeprofit/disable_negative_profit',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Calculates a minimum price that is allowed to set on an item in a proposal
     * @return int
     */
    public function getMinPrice()
    {
        $item = $this->getItem();
        if (!$this->isDisabledNegativeProfit() || $item == null) {
            return 0;
        }

        return $item->getBaseCost() != null ? $item->getBaseCost() : 0;
    }
}
