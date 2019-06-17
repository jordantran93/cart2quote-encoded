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

namespace Cart2Quote\Quotation\Block\Quote\Email\Items;

/**
 * Quote Email items default renderer
 *
 * Class DefaultItems
 * @package Cart2Quote\Quotation\Block\Quote\Email\Items
 */
class DefaultItems extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $quotationHelper;

    /**
     * @var \Cart2Quote\Quotation\Block\Quote\TierItem
     */
    protected $tierItemBlock;

    /**
     * DefaultItems constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Cart2Quote\Quotation\Helper\Data $quotationHelper
     * @param \Cart2Quote\Quotation\Block\Quote\TierItem $tierItemBlock
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Cart2Quote\Quotation\Helper\Data $quotationHelper,
        \Cart2Quote\Quotation\Block\Quote\TierItem $tierItemBlock,
        array $data = []
    ) {
        $this->quotationHelper = $quotationHelper;
        $this->tierItemBlock = $tierItemBlock;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current quote model instance
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getQuote()
    {
        return $this->getItem()->getQuote();
    }

    /**
     * @return array
     */
    public function getItemOptions()
    {
        $result = [];
        if ($options = $this->getItem()->getQuoteItem()->getProductOptions()) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (isset($options['attributes_info'])) {
                $result = array_merge($result, $options['attributes_info']);
            }
        }

        return $result;
    }

    /**
     * @param string|array $value
     * @return string
     */
    public function getValueHtml($value)
    {
        if (is_array($value)) {
            return sprintf(
                '%d x %d %d',
                $value['qty'],
                $this->escapeHtml($value['title']),
                $this->getItem()->getQuote()->formatPrice($value['price'])
            );
        } else {
            return $this->escapeHtml($value);
        }
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return string
     */
    public function getSku($item)
    {
        if ($item->getQuoteItem()->getProductOptionByCode('simple_sku')) {
            return $item->getQuoteItem()->getProductOptionByCode('simple_sku');
        } else {
            return $item->getSku();
        }
    }

    /**
     * Return product additional information block
     *
     * @return boolean|\Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getProductAdditionalInformationBlock()
    {
        return $this->getLayout()->getBlock('additional.product.info');
    }

    /**
     * Get the html for item price
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getItemPrice($item)
    {
        $block = $this->getLayout()->getBlock('item_row_total');
        $block->setItem($item);
        return $block->toHtml();
    }

    /**
     * Check disabled product remark field
     * @return boolean
     */
    public function isProductRemarkDisabled()
    {
        return $this->quotationHelper->isProductRemarkDisabled();
    }

    /**
     * Get tier item quantity
     *
     * @return string
     */
    public function getTierQtyHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'qty', true);
    }

    /**
     * Get item quantity
     *
     * @return string
     */
    public function getQtyHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'qty');
    }

    /**
     * Get tier item price
     *
     * @return string
     */
    public function getTierPriceHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'price', true);
    }

    /**
     * Get item price
     *
     * @return string
     */
    public function getPriceHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'price');
    }

    /**
     * Get tier item row total
     *
     * @return string
     */
    public function getTierRowTotalHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'subtotal', true);
    }

    /**
     * Get item row total
     *
     * @return string
     */
    public function getRowTotalHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'subtotal');
    }

    /**
     * Check hide item price in request email configuration
     *
     * @return boolean
     */
    public function hidePrice()
    {
        return $this->quotationHelper->isHideEmailRequestPrice();
    }
}
