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

namespace Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items;

/**
 * Class PriceRenderer
 * @package Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items
 */
class PriceRenderer extends DefaultRenderer
{
    /**
     * Calculate total amount for the (tier) item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getBaseTotalAmount($item)
    {
        $calculateItem = $item;
        if ($item->getTierItem()) {
            $calculateItem = $item->getTierItem();
        }

        return $this->itemPriceRenderer->getBaseTotalAmount($calculateItem);
    }

    /**
     * Calculate total amount for the (tier) item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getTotalAmount($item)
    {
        $calculateItem = $item;
        if ($item->getTierItem()) {
            $calculateItem = $item->getTierItem();
        }

        return $this->itemPriceRenderer->getTotalAmount($calculateItem);
    }

    /**
     * Calculate total amount excl. tax for the (tier) item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getTotalAmountExclTax($item)
    {
        $calculateItem = $item;
        if ($item->getTierItem()) {
            $calculateItem = $item->getTierItem();
        }

        return $calculateItem->getRowTotal() - $calculateItem->getDiscountAmount();
    }

    /**
     * Calculate base total amount excl. tax for the (tier) item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getBaseTotalAmountExclTax($item)
    {
        $calculateItem = $item;
        if ($item->getTierItem()) {
            $calculateItem = $item->getTierItem();
        }

        return $calculateItem->getBaseRowTotal() - $calculateItem->getBaseDiscountAmount();
    }
}
