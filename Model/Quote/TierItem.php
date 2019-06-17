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

namespace Cart2Quote\Quotation\Model\Quote;

/**
 * Class TierItem
 * @package Cart2Quote\Quotation\Model\Quote
 */
class TierItem extends \Magento\Sales\Model\AbstractModel implements \Cart2Quote\Quotation\Api\Data\QuoteTierItemInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\TierItem {
		getItemId as private traitGetItemId;
		setEntityId as private traitSetEntityId;
		getEntityId as private traitGetEntityId;
		getBaseOriginalPrice as private traitGetBaseOriginalPrice;
		getBaseCustomPrice as private traitGetBaseCustomPrice;
		setCostPrice as private traitSetCostPrice;
		setBaseCostPrice as private traitSetBaseCostPrice;
		getRowTotal as private traitGetRowTotal;
		setRowTotal as private traitSetRowTotal;
		getBaseRowTotal as private traitGetBaseRowTotal;
		setBaseRowTotal as private traitSetBaseRowTotal;
		getDiscountAmount as private traitGetDiscountAmount;
		setDiscountAmount as private traitSetDiscountAmount;
		getBaseDiscountAmount as private traitGetBaseDiscountAmount;
		setBaseDiscountAmount as private traitSetBaseDiscountAmount;
		getMakeOptional as private traitGetMakeOptional;
		setMakeOptional as private traitSetMakeOptional;
		setSelected as private traitSetSelected;
		getItem as private traitGetItem;
		resetQuoteItem as private traitResetQuoteItem;
		getQty as private traitGetQty;
		getOriginalPrice as private traitGetOriginalPrice;
		getBaseCostPrice as private traitGetBaseCostPrice;
		getCostPrice as private traitGetCostPrice;
		setSelectedChild as private traitSetSelectedChild;
		calculateChildTotalPrice as private traitCalculateChildTotalPrice;
		calculateChildPrice as private traitCalculateChildPrice;
		calculatePercentage as private traitCalculatePercentage;
		calculatePrice as private traitCalculatePrice;
		setItem as private traitSetItem;
		setItemId as private traitSetItemId;
		loadPriceOnItem as private traitLoadPriceOnItem;
		getCustomPrice as private traitGetCustomPrice;
		setCustomPrice as private traitSetCustomPrice;
		checkBundleRoundingIssue as private traitCheckBundleRoundingIssue;
		setDataByItem as private traitSetDataByItem;
		setQty as private traitSetQty;
		setNewPrice as private traitSetNewPrice;
		getCurrencyPrice as private traitGetCurrencyPrice;
		getBaseToQuoteRate as private traitGetBaseToQuoteRate;
		setBaseOriginalPrice as private traitSetBaseOriginalPrice;
		setBaseCustomPrice as private traitSetBaseCustomPrice;
		setOriginalPrice as private traitSetOriginalPrice;
		loadPriceOnProduct as private traitLoadPriceOnProduct;
		isSelected as private traitIsSelected;
		_construct as private _traitConstruct;
		getTaxCalculationRate as private traitGetTaxCalculationRate;
		getQuote as private traitGetQuote;
	}

	/**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'quotation_quote_item';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'item';

    /**
     * Quote item collection factory
     *
     * @var \Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory
     */
    protected $quoteItemCollectionFactory;

    /**
     * Tier item collection factory
     *
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory
     */
    protected $tierItemCollectionFactory;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    protected $quoteRepository;

    /**
     * @var \Magento\Tax\Helper\Data
     */
    protected $taxHelper;

    /**
     * @var \Magento\Tax\Api\TaxCalculationInterface
     */
    private $taxCalculationService;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    private $quote;

    /**
     * @var \Cart2Quote\Quotation\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * TierItem constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem $resource
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $resourceCollection
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory
     * @param \Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory $quoteItemCollectionFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Tax\Helper\Data $taxHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem $resource,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $resourceCollection,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory,
        \Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory $quoteItemCollectionFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Tax\Helper\Data $taxHelper,
        \Magento\Tax\Api\TaxCalculationInterface $taxCalculationService,
        \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );

        $this->quoteItemCollectionFactory = $quoteItemCollectionFactory;
        $this->tierItemCollectionFactory = $tierItemCollectionFactory;
        $this->quoteRepository = $quoteRepository;
        $this->taxHelper = $taxHelper;
        $this->taxCalculationService = $taxCalculationService;
        $this->quoteFactory = $quoteFactory;
        $this->productRepository = $productRepository;
    }

    /**
     * Get item id
     *
     * @return int $itemId
     */
    public function getItemId()
    {
        return $this->traitGetItemId();
    }

    /**
     * Set entity id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId)
    {
        return $this->traitSetEntityId($entityId);
    }

    /**
     * Set entity id
     *
     * @return int
     */
    public function getEntityId()
    {
        return $this->traitGetEntityId();
    }

    /**
     * Set base original price
     *
     * @return float
     */
    public function getBaseOriginalPrice()
    {
        return $this->traitGetBaseOriginalPrice();
    }

    /**
     * Get Base Custom Price
     *
     * @return float
     */
    public function getBaseCustomPrice()
    {
        return $this->traitGetBaseCustomPrice();
    }

    /**
     * Set cost price
     *
     * @param float $costPrice
     * @return $this
     */
    public function setCostPrice($costPrice)
    {
        return $this->traitSetCostPrice($costPrice);
    }

    /**
     * Set base cost price
     *
     * @param float $baseCostPrice
     * @return $this
     */
    public function setBaseCostPrice($baseCostPrice)
    {
        return $this->traitSetBaseCostPrice($baseCostPrice);
    }

    /**
     * Get cost price
     *
     * @return float
     */
    public function getRowTotal()
    {
        return $this->traitGetRowTotal();
    }

    /**
     * Set cost price
     *
     * @param float $costPrice
     * @return $this
     */
    public function setRowTotal($costPrice)
    {
        return $this->traitSetRowTotal($costPrice);
    }

    /**
     * Get base cost price
     *
     * @return float
     */
    public function getBaseRowTotal()
    {
        return $this->traitGetBaseRowTotal();
    }

    /**
     * Set base cost price
     *
     * @param float $baseCostPrice
     * @return $this
     */
    public function setBaseRowTotal($baseCostPrice)
    {
        return $this->traitSetBaseRowTotal($baseCostPrice);
    }

    /**
     * Get discount amount
     *
     * @return float
     */
    public function getDiscountAmount()
    {
        return $this->traitGetDiscountAmount();
    }

    /**
     * Set discount amount
     *
     * @param float $discountAmount
     * @return $this
     */
    public function setDiscountAmount($discountAmount)
    {
        return $this->traitSetDiscountAmount($discountAmount);
    }

    /**
     * Get base discount amount
     *
     * @return float
     */
    public function getBaseDiscountAmount()
    {
        return $this->traitGetBaseDiscountAmount();
    }

    /**
     * Set base discount amount
     *
     * @param float $baseDiscountAmount
     * @return $this
     */
    public function setBaseDiscountAmount($baseDiscountAmount)
    {
        return $this->traitSetBaseDiscountAmount($baseDiscountAmount);
    }

    /**
     * Make optional
     *
     * @return boolean
     */
    public function getMakeOptional()
    {
        return $this->traitGetMakeOptional();
    }

    /**
     * Set make optional
     *
     * @param boolean $makeOptional
     * @return $this
     */
    public function setMakeOptional($makeOptional)
    {
        return $this->traitSetMakeOptional($makeOptional);
    }

    /**
     * Set selected
     *
     * @return \Magento\Quote\Model\Quote\Item $item
     */
    public function setSelected()
    {
        return $this->traitSetSelected();
    }

    /**
     * Get item
     *
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function getItem()
    {
        return $this->traitGetItem();
    }

    /**
     * Reset the quote item prices
     *
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @return \Magento\Quote\Model\Quote\Item
     */
    protected function resetQuoteItem($quoteItem)
    {
        return $this->traitResetQuoteItem($quoteItem);
    }

    /**
     * Get qty
     *
     * @return float $qty
     */
    public function getQty()
    {
        return $this->traitGetQty();
    }

    /**
     * Get original price
     *
     * @return float
     */
    public function getOriginalPrice()
    {
        return $this->traitGetOriginalPrice();
    }

    /**
     * Get base cost price
     *
     * @return float
     */
    public function getBaseCostPrice()
    {
        return $this->traitGetBaseCostPrice();
    }

    /**
     * Get cost price
     *
     * @return float
     */
    public function getCostPrice()
    {
        return $this->traitGetCostPrice();
    }

    /**
     * Set selected for child
     * The child tier prices are calculated based on the parent tier item
     *
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @return $this
     */
    protected function setSelectedChild($quoteItem)
    {
        return $this->traitSetSelectedChild($quoteItem);
    }

    /**
     * Get total child price
     *
     * @param $children
     * @return int
     */
    protected function calculateChildTotalPrice($children)
    {
        return $this->traitCalculateChildTotalPrice($children);
    }

    /**
     * Calculate the child price
     *
     * @param \Magento\Quote\Model\Quote\Item $child
     * @param $totalChildPrice
     * @return float
     */
    public function calculateChildPrice(\Magento\Quote\Model\Quote\Item $child, $totalChildPrice)
    {
        return $this->traitCalculateChildPrice($child, $totalChildPrice);
    }

    /**
     * Calculate percentage
     *
     * @param float $total
     * @param $subject
     * @return float
     */
    public function calculatePercentage($total, $subject)
    {
        return $this->traitCalculatePercentage($total, $subject);
    }

    /**
     * Calculate price
     *
     * @param float $total
     * @param float $percentage
     * @return float
     */
    public function calculatePrice($total, $percentage)
    {
        return $this->traitCalculatePrice($total, $percentage);
    }

    /**
     * Set item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return $this
     */
    public function setItem(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitSetItem($item);
    }

    /**
     * Set item id
     *
     * @param int $itemId
     * @return $this
     */
    public function setItemId($itemId)
    {
        return $this->traitSetItemId($itemId);
    }

    /**
     * Load the tier price on the quote item
     *
     * @param \Magento\Quote\Model\Quote\Item $quoteItem
     * @return $this
     */
    public function loadPriceOnItem(&$quoteItem)
    {
        return $this->traitLoadPriceOnItem($quoteItem);
    }

    /**
     * Get custom price
     *
     * @return float
     */
    public function getCustomPrice()
    {
        return $this->traitGetCustomPrice();
    }

    /**
     * Set custom price
     *
     * @param float $customPrice
     * @return $this
     */
    public function setCustomPrice($customPrice)
    {
        return $this->traitSetCustomPrice($customPrice);
    }

    /**
     * Adds the rounding differences to the tier item (won't be saved in the DB)
     * You can use this to detect rounding issues for bundles
     *
     * @param $totalCalculatedChildPrice
     */
    protected function checkBundleRoundingIssue($totalCalculatedChildPrice)
    {
        $this->traitCheckBundleRoundingIssue($totalCalculatedChildPrice);
    }

    /**
     * Set the tier item data base the quote item values
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param null $tierItemId
     * @param null $qty
     * @return $this
     */
    public function setDataByItem(\Magento\Quote\Model\Quote\Item $item, $tierItemId = null, $qty = null)
    {
        return $this->traitSetDataByItem($item, $tierItemId, $qty);
    }

    /**
     * Set qty
     *
     * @param float $qty
     * @return $this
     */
    public function setQty($qty)
    {
        return $this->traitSetQty($qty);
    }

    /**
     * Set a custom price
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return $this
     */
    protected function setNewPrice(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitSetNewPrice($item);
    }

    /**
     * Calculate quote currency to the price
     *
     * @param $price
     * @return float
     */
    public function getCurrencyPrice($price)
    {
        return $this->traitGetCurrencyPrice($price);
    }

    /**
     * Get base_to_quote_rate from quote
     *
     * @return float
     */
    public function getBaseToQuoteRate()
    {
        return $this->traitGetBaseToQuoteRate();
    }

    /**
     * Set base original price
     *
     * @param float $baseOriginalPrice
     * @return $this
     */
    public function setBaseOriginalPrice($baseOriginalPrice)
    {
        return $this->traitSetBaseOriginalPrice($baseOriginalPrice);
    }

    /**
     * Set Base Custom Price
     *
     * @param float $baseCustomPrice
     * @return $this
     */
    public function setBaseCustomPrice($baseCustomPrice)
    {
        return $this->traitSetBaseCustomPrice($baseCustomPrice);
    }

    /**
     * Set original price
     *
     * @param float $originalPrice
     * @return $this
     */
    public function setOriginalPrice($originalPrice)
    {
        return $this->traitSetOriginalPrice($originalPrice);
    }

    /**
     * Load the tier price on the product
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return $this
     */
    public function loadPriceOnProduct(&$product)
    {
        return $this->traitLoadPriceOnProduct($product);
    }

    /**
     * Is tier selected
     *
     * @return bool
     */
    public function isSelected()
    {
        return $this->traitIsSelected();
    }

    /**
     * Init resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }

    /**
     * Function that gets the tax rate in a calculation value (x.xx)
     *
     * @param  \Magento\Quote\Model\Quote\Item $item
     * @return float|int
     */
    public function getTaxCalculationRate(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitGetTaxCalculationRate($item);
    }

    /**
     * Get Quotation Quote
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getQuote()
    {
        return $this->traitGetQuote();
    }
}
