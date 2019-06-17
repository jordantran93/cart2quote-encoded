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

use Cart2Quote\Quotation\Model\Quote\TierItem;
use Magento\CatalogInventory\Api\StockRegistryInterface;

/**
 * Class DefaultColumn
 * @package Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items
 */
class DefaultRenderer extends \Magento\Sales\Block\Adminhtml\Items\Column\DefaultColumn implements FooterInterface
{
    /**
     * Quotation Quote
     *
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    protected $quote;

    /**
     * Empty Quote item
     *
     * @var \Magento\Quote\Model\Quote\Item
     */
    protected $emptyQuoteItem;

    /**
     * @var \Magento\Tax\Helper\Data
     */
    protected $taxHelper;

    /**
     * @var \Magento\Tax\Block\Item\Price\Renderer
     */
    protected $itemPriceRenderer;

    /**
     * DefaultRenderer constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param StockRegistryInterface $stockRegistry
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
        $this->quote = $quote;
        $this->emptyQuoteItem = $emptyQuoteItem;
        $this->taxHelper = $taxHelper;
        $this->itemPriceRenderer = $itemPriceRenderer;
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $optionFactory, $data);
    }

    /**
     * OVERWRITE Magento getOrder function
     * Retrieve quote model object
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getOrder()
    {
        return $this->getQuote();
    }

    /**
     * Retrieve quote model object
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getQuote()
    {
        if (!$quote = $this->_coreRegistry->registry('current_quote')) {
            $this->_coreRegistry->register(
                'current_quote',
                $this->quote->load($this->getRequest()->getParam('quote_id'))
            );
        }

        return $quote;
    }

    /**
     * Format price with custom return
     *
     * @param int $value
     * @param string|int $zero
     * @return string
     */
    public function formatPriceZero($value, $zero)
    {
        if (isset($value) && $value > 0) {
            return $this->formatPrice($value);
        }

        return $zero;
    }

    /**
     * Get the footer HTML
     *
     * @return string
     */
    public function toFooterHtml()
    {
        return $this->getChildHtml('footer.' . $this->getNameInLayout());
    }

    /**
     * Get the item count
     *
     * @return int
     */
    public function getItemCount()
    {
        $count = $this->getData('item_count');
        if ($count === null) {
            $count = $this->getItems()->getSize();
            $this->setData('item_count', $count);
        }

        return $count;
    }

    /**
     * Get the items
     *
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection
     * @throws \Exception
     */
    public function getItems()
    {
        return $this->getItemsBlock()->getItems();
    }

    /**
     * Get the item block
     *
     * @return \Cart2Quote\Quotation\Block\Adminhtml\Quote\View\Items\GridItems
     * @throws \Exception
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getItemsBlock()
    {
        if (!$itemBlock = $this->getLayout()->getBlock('items')) {
            throw new \Exception('Quote Items render error: "items"' .
                ' needs to be a child of the block "' . $this->getNameInLayout() . '"');
        }

        return $itemBlock;
    }

    /**
     * Get col span if there are more tier items
     *
     * @param string $columnName
     * @return string
     */
    public function getRowSpan($columnName)
    {
        $html = '';

        if ($this->getTotalTierItemCount() && !$this->isTierColumn($columnName)) {
            $html = sprintf('rowspan="%s"', $this->getTotalTierItemCount());
        }

        return $html;
    }

    /**
     * Get the tier item count
     *
     * @return int
     */
    public function getTotalTierItemCount()
    {
        return count($this->getItem()->getTierItems());
    }

    /**
     * Get item
     *
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function getItem()
    {
        $item = $this->_getData('item');
        if ($item instanceof \Magento\Quote\Model\Quote\Item) {
            return $item;
        } else {
            return $this->emptyQuoteItem;
        }
    }

    /**
     * Check if column is tier column
     *
     * @param string $columnName
     * @return bool
     */
    public function isTierColumn($columnName)
    {
        $tierColumns = $this->getTierColumns();

        return isset($tierColumns[$columnName]) && $tierColumns[$columnName];
    }

    /**
     * Get empty column html
     *
     * @param \Magento\Framework\DataObject $item
     * @param string $column
     * @param null $field
     * @return string
     */
    public function getEmptyColumnHtml(\Magento\Framework\DataObject $item, $column, $field = null)
    {
        $html = '';
        $columnRenderer = $this->getColumnRenderer($column, $item->getProductType());
        $emptyColumn = $columnRenderer->getChildBlock('empty.' . $columnRenderer->getNameInLayout());
        if ($emptyColumn) {
            $html = $emptyColumn->setItem($item)->setField($field)->toHtml();
        }

        return $html;
    }

    /**
     * Get the select tier css class
     *
     * @return string
     */
    public function getSelectedTierClass()
    {
        if ($this->getItem()->getIsSelectedTier()) {
            return 'selected-tier-row';
        } else {
            return '';
        }
    }

    /**
     * Get the item id
     *
     * @return int|null
     */
    public function getItemId()
    {
        return $this->getItem()->getId();
    }

    /**
     * Get the tier item set by the parent
     *
     * @return TierItem|null
     */
    public function getTierItem()
    {
        return $this->getItem()->getTierItem();
    }

    /**
     * Get flag for first tier item
     *
     * @return bool|null
     */
    public function getIsFirstTierItem()
    {
        return $this->getItem()->getIsFirstTierItem();
    }

    /**
     * Get the current tier count (starts from 0)
     *
     * @return int|null
     */
    public function getTierItemCount()
    {
        return $this->getItem()->getTierItemCount();
    }

    /**
     * Get flag for selected tier (the tier selected for this quote item)
     *
     * @return bool|null
     */
    public function getIsSelectedTier()
    {
        return $this->getItem()->getIsSelectedTier();
    }

    /**
     * Check if prices of product in catalog include tax
     *
     * @return bool
     */
    public function priceIncludesTax()
    {
        return $this->taxHelper->priceIncludesTax($this->getItem()->getStoreId());
    }

    /**
     * Returns the product price, including tax if applicable
     *
     * @param $price
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getPriceAfterTax($price, \Magento\Quote\Model\Quote\Item $item)
    {
        if ($item) {
            $price *= $this->getProductTaxCalculationRate($item);
        }

        return $price;
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote\TierItem $tierItem
     * @return float
     */
    public function getOriginalPriceInclTax($tierItem)
    {
        $originalPrice = $tierItem->getOriginalPrice();

        return $this->getPriceAfterTax($originalPrice, $tierItem->getItem());
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote\TierItem $tierItem
     * @return float
     */
    public function getBaseOriginalPriceInclTax($tierItem)
    {
        $baseOriginalPrice = $tierItem->getBaseOriginalPrice();

        return $this->getPriceAfterTax($baseOriginalPrice, $tierItem->getItem());
    }

    /**
     * Calculate base total amount for the (tier) item including tax
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getBaseTotalAmountInclTax(\Magento\Quote\Model\Quote\Item $item)
    {
        return $item->getCurrentTierItem()->getBaseRowTotal()
            - $item->getCurrentTierItem()->getBaseDiscountAmount()
            + $item->getCurrentTierItem()->getBaseTaxAmount()
            + $item->getCurrentTierItem()->getBaseDiscountTaxCompensationAmount();
    }

    /**
     * Calculate total amount for the (tier) item including tax
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getTotalAmountInclTax(\Magento\Quote\Model\Quote\Item $item)
    {
        return $item->getCurrentTierItem()->getRowTotal()
            + $item->getCurrentTierItem()->getTaxAmount()
            - $item->getCurrentTierItem()->getDiscountAmount();
    }

    /**
     * Get Item Tax Rate from the Selected Tier
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float
     */
    public function getProductTaxCalculationRate(\Magento\Quote\Model\Quote\Item $item)
    {
        $tax = 1.00; //percent calculation value, equals 100%
        /**
         * @var TierItem $currentTierItem
         */
        if ($currentTierItem = $item->getTierItem()) {
            $tax = $currentTierItem->getTaxCalculationRate($item);
        }

        return $tax;
    }

    /**
     * Get cost total
     *
     * @return float | null
     */
    public function getCostTotal()
    {
        $totalCost = 0;
        foreach ($this->getQuote()->getAllVisibleItems() as $item) {
            $itemCost = $this->getItemCost($item);
            $totalCost += $itemCost * $item->getQty();
        }

        return $totalCost;
    }

    /**
     * Get item cost
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return float | null
     */
    public function getItemCost(\Magento\Quote\Model\Quote\Item $item)
    {
        $itemCost = $item->getBaseCost();
        $quote = $this->getQuote();
        $quoteCurrency = $quote->getQuoteCurrency();

        if ($quoteCurrency != $quote->getBaseCurrency()) {
            try {
                $itemCost = $this->_storeManager->getStore()->getBaseCurrency()->convert($itemCost, $quoteCurrency);
            } catch (\Exception $e) {
                $logMessage = sprintf("No conversion rate set: %s", $e);
                $this->_logger->notice($logMessage);

                return null;
            }
        }

        return $itemCost;
    }

    /**
     * Checks if every item in the Quote has a Cost Price
     *
     * @return bool
     */
    public function getEveryItemHasCost()
    {
        foreach ($this->getQuote()->getAllVisibleItems() as $item) {
            if (is_null($this->getItemCost($item))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return whether display setting is to display price including tax
     *
     * @return bool
     */
    public function displayPriceInclTax()
    {
        return $this->itemPriceRenderer->displayPriceInclTax();
    }

    /**
     * Return whether display setting is to display price excluding tax
     *
     * @return bool
     */
    public function displayPriceExclTax()
    {
        return $this->itemPriceRenderer->displayPriceExclTax();
    }

    /**
     * Return whether display setting is to display both price including tax and price excluding tax
     *
     * @return bool
     */
    public function displayBothPrices()
    {
        return $this->itemPriceRenderer->displayBothPrices();
    }

    /**
     * @return float
     */
    public function getQuoteBaseOriginalSubtotalInclTax()
    {
        $total = 0;
        $quote = $this->getOrder();
        foreach ($quote->getItemsCollection() as $quoteItem) {
            $tierItem = $quoteItem->getCurrentTierItem();
            $qty = $tierItem->getQty();
            $baseOriginalPriceInclTax =  $this->getBaseOriginalPriceInclTax($tierItem);
            $total += $baseOriginalPriceInclTax * $qty;
        }

        return $total;
    }

    /**
     * @return float
     */
    public function getQuoteOriginalSubtotalInclTax()
    {
        $total = 0;
        $quote = $this->getOrder();
        foreach ($quote->getItemsCollection() as $quoteItem) {
            $tierItem = $quoteItem->getCurrentTierItem();
            $qty = $tierItem->getQty();
            $originalPriceInclTax =  $this->getOriginalPriceInclTax($tierItem);
            $total += $originalPriceInclTax * $qty;
        }

        return $total;
    }
}
