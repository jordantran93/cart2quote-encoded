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

namespace Cart2Quote\Quotation\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class MarginCalculation
 * @package Cart2Quote\Quotation\Helper
 */
class MarginCalculation extends AbstractHelper
{
    /**
     * @param $price
     * @param $cost
     * @return float
     */
    public function calculatePercentage($price, $cost)
    {
        if ($price == $cost) {
            return 0.00;
        }

        return round((($price - $cost) / $price) * 100, 1);
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param $marginBlock
     * @return float | null
     */
    public function itemMargin(\Magento\Quote\Model\Quote\Item $item)
    {
        $price = $item->getTierItem()->getCustomPrice();
        if ($price > 0) {
            if ($item['no_discount'] == false) {
                $price *= ((100 - $item['discount_percent']) / 100);
            }
            $cost = $item->getProduct()->getCost();

            /**
             * If cost is not known, no GPMargin is calculated
             */
            if ($cost == null) {
                return null;
            }

            return $this->calculatePercentage($price, $cost);
        }
    }
}
