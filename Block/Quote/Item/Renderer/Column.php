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
namespace Cart2Quote\Quotation\Block\Quote\Item\Renderer;

/**
 * Class Column
 * @package Cart2Quote\Quotation\Block\Quote\Item\Renderer
 */
class Column extends DefaultRenderer
{
    /**
     * Get the item from the parent block
     *
     * @return \Magento\Quote\Model\Quote\Item
     * @throws \Exception
     */
    public function getItem()
    {
        if ($parentBlock = $this->getParentBlock()) {
            return $parentBlock->getItem();
        } else {
            throw new \Exception('Undefined quote item in block ' . $this->getNameInLayout());
        }
    }

    /**
     * Get tier item quantity
     *
     * @return string
     * @throws \Exception
     */
    public function getTierQtyHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'qty', true);
    }

    /**
     * Get item quantity
     *
     * @return string
     * @throws \Exception
     */
    public function getQtyHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'qty');
    }

    /**
     * Get tier item price
     *
     * @return string
     * @throws \Exception
     */
    public function getTierPriceHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'price', true);
    }

    /**
     * Get item price
     *
     * @return string
     * @throws \Exception
     */
    public function getPriceHtml()
    {
        $formattedPrice = $this->tierItemBlock->getItemHtml($this->getItem(), 'price');
        return sprintf("<span class='c2q-price price-excluding-tax'> %s </span>", $formattedPrice);
    }

    /**
     * Get tier item row total
     *
     * @return string
     * @throws \Exception
     */
    public function getTierRowTotalHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'subtotal', true);
    }

    /**
     * Get item row total
     *
     * @return string
     * @throws \Exception
     */
    public function getRowTotalHtml()
    {
        $formattedPrice = $this->tierItemBlock->getItemHtml($this->getItem(), 'subtotal');
        return sprintf("<span class='c2q-price price-excluding-tax'> %s </span>", $formattedPrice);
    }

    /**
     * Get selected tier radio button html
     *
     * @return string
     * @throws \Exception
     */
    public function getSelectedRadiobuttonHtml()
    {
        return sprintf(
            "<input checked type='radio' class='qty-tier' name='%s' value='%s'>",
            $this->getItem()->getId(),
            $this->getItem()->getCurrentTierItem()->getId()
        );
    }

    /**
     * Get tier radio buttons html
     *
     * @return string
     * @throws \Exception
     */
    public function getTierRadiobuttonsHtml()
    {
        $linebreak = '<div class="single-price-break"></div>';
        if ($this->tierItemBlock->isDisplayBothPrices()) {
            $linebreak = '<div class="both-prices-break"></div>';
        }
        $tierHtml = $linebreak;
        $item = $this->getItem();
        $tierItems = $item->getTierItems();

        if (isset($tierItems)) {
            foreach ($tierItems as $tierItemId => $tierItem) {
                if (!$this->tierItemBlock->isTierSelected($item, $tierItem->getId())) {
                    $tierHtml .= sprintf(
                        "<input type='radio' class='qty-tier' name='%s' value='%s'>%s",
                        $this->getItem()->getId(),
                        $tierItem->getId(),
                        $linebreak
                    );
                }
            }
        }

        return $tierHtml;
    }

    /**
     * Get config setting for hide prices dashboard
     *
     * @return bool
     */
    public function isHidePrices()
    {
        return $this->quotationHelper->isHidePrices($this->getQuote());
    }
}
