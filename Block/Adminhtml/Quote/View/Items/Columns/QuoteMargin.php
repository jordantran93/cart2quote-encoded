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

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Quote\Model\Quote\Item;

/**
 * Class Margin
 * @package Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\Columns
 */
class QuoteMargin extends \Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\DefaultRenderer
{
    const TOTAL = 'total';
    const INDIVIDUAL = 'individual';
    /**
     * @var \Cart2Quote\Quotation\Helper\MarginCalculation
     */
    private $marginCalculationHelper;

    /**
     * QuoteMargin constructor.
     * @param \Cart2Quote\Quotation\Helper\MarginCalculation $marginCalculationHelper
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Catalog\Model\Product\OptionFactory $optionFactory
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @param \Magento\Quote\Model\Quote\Item $emptyQuoteItem
     * @param \Magento\Tax\Helper\Data $taxHelper
     * @param \Magento\Tax\Block\Item\Price\Renderer $itemPriceRenderer
     * @param array $data
     */
    public function __construct(
        \Cart2Quote\Quotation\Helper\MarginCalculation $marginCalculationHelper,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Product\OptionFactory $optionFactory,
        \Cart2Quote\Quotation\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Item $emptyQuoteItem,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Tax\Block\Item\Price\Renderer $itemPriceRenderer,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $stockRegistry,
            $stockConfiguration,
            $registry,
            $optionFactory,
            $quote,
            $emptyQuoteItem,
            $taxHelper,
            $itemPriceRenderer,
            $data
        );

        $this->marginCalculationHelper = $marginCalculationHelper;
    }


    /**
     * @return string
     */
    public function getTotalMargin($quoteTotal, $costTotal)
    {
        return $this->marginCalculationHelper->calculatePercentage($quoteTotal, $costTotal);
    }

    /**
     * Calculate the profit Margin based on
     * the item's cost price and the quoted price.
     * @param Item $item
     * @param string $marginBlock | null
     * @return string
     *
     */
    public function getMargin(\Magento\Quote\Model\Quote\Item $item)
    {
        $margin = $this->marginCalculationHelper->itemMargin($item);
        if ($margin) {
            return $margin;
        }

        return null;
    }
}
