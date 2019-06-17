<?php
/**
 * CART2QUOTE CONFIDENTIAL
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
 *
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 */

namespace Cart2Quote\Quotation\Model\Admin\Quote;

use Magento\Quote\Model\Quote\Item;

/**
 * Class Create
 * @package Cart2Quote\Quotation\Model\Admin\Quote
 */
class Create extends \Magento\Sales\Model\AdminOrder\Create
{

    use \Cart2Quote\Features\Traits\Model\Admin\Quote\Create {
		updateTierItems as private traitUpdateTierItems;
		processOptionalValues as private traitProcessOptionalValues;
		processCustomPrice as private traitProcessCustomPrice;
		processItems as private traitProcessItems;
		processBundle as private traitProcessBundle;
		processConfigurable as private traitProcessConfigurable;
		processQuantity as private traitProcessQuantity;
		processExistingTierItems as private traitProcessExistingTierItems;
		processNewTierItems as private traitProcessNewTierItems;
		calculateTierPrices as private traitCalculateTierPrices;
		setCurrentTierItemData as private traitSetCurrentTierItemData;
	}

	/**
     * Tier item factory
     *
     * @var \Cart2Quote\Quotation\Model\Quote\TierItemFactory
     */
    protected $tierItemFactory;

    /**
     * Tier item collection factory
     *
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory
     */
    protected $tierItemCollectionFactory;

    /**
     * The calculation quote (duplicate of the original)
     *
     * @var \Magento\Quote\Model\Quote
     */
    protected $calculationQuote;

    /**
     * @var \Magento\CatalogInventory\Model\StockStateProvider
     */
    protected $stockStateProvider;

    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $quotationDataHelper;

    /**
     * Create constructor.
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Sales\Model\Config $salesConfig
     * @param \Magento\Backend\Model\Session\Quote $quoteSession
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\DataObject\Copy $objectCopyService
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Sales\Model\AdminOrder\Product\Quote\Initializer $quoteInitializer
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory
     * @param \Magento\Customer\Model\Metadata\FormFactory $metadataFormFactory
     * @param \Magento\Customer\Api\GroupRepositoryInterface $groupRepository
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Sales\Model\AdminOrder\EmailSender $emailSender
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param Item\Updater $quoteItemUpdater
     * @param \Magento\Framework\DataObject\Factory $objectFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Customer\Api\AccountManagementInterface $accountManagement
     * @param \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory
     * @param \Magento\Customer\Model\Customer\Mapper $customerMapper
     * @param \Magento\Quote\Api\CartManagementInterface $quoteManagement
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Sales\Api\OrderManagementInterface $orderManagement
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     * @param \Cart2Quote\Quotation\Model\Session $quotationSession
     * @param \Cart2Quote\Quotation\Model\Quote\TierItemFactory $tierItemFactory
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory
     * @param \Magento\CatalogInventory\Model\StockStateProvider $stockStateProvider
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Cart2Quote\Quotation\Helper\Data $quotationDataHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Sales\Model\Config $salesConfig,
        \Magento\Backend\Model\Session\Quote $quoteSession,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\DataObject\Copy $objectCopyService,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Sales\Model\AdminOrder\Product\Quote\Initializer $quoteInitializer,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressFactory,
        \Magento\Customer\Model\Metadata\FormFactory $metadataFormFactory,
        \Magento\Customer\Api\GroupRepositoryInterface $groupRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Sales\Model\AdminOrder\EmailSender $emailSender,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Quote\Model\Quote\Item\Updater $quoteItemUpdater,
        \Magento\Framework\DataObject\Factory $objectFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Customer\Api\AccountManagementInterface $accountManagement,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerFactory,
        \Magento\Customer\Model\Customer\Mapper $customerMapper,
        \Magento\Quote\Api\CartManagementInterface $quoteManagement,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        \Magento\Quote\Model\QuoteFactory $quoteFactory,
        \Cart2Quote\Quotation\Model\Session $quotationSession,
        \Cart2Quote\Quotation\Model\Quote\TierItemFactory $tierItemFactory,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory,
        \Magento\CatalogInventory\Model\StockStateProvider $stockStateProvider,
        \Magento\Catalog\Helper\Product $productHelper,
        \Cart2Quote\Quotation\Helper\Data $quotationDataHelper,
        array $data = []
    ) {
        parent::__construct(
            $objectManager,
            $eventManager,
            $coreRegistry,
            $salesConfig,
            $quoteSession,
            $logger,
            $objectCopyService,
            $messageManager,
            $quoteInitializer,
            $customerRepository,
            $addressRepository,
            $addressFactory,
            $metadataFormFactory,
            $groupRepository,
            $scopeConfig,
            $emailSender,
            $stockRegistry,
            $quoteItemUpdater,
            $objectFactory,
            $quoteRepository,
            $accountManagement,
            $customerFactory,
            $customerMapper,
            $quoteManagement,
            $dataObjectHelper,
            $orderManagement,
            $quoteFactory,
            $data
        );

        // Overwrite the Magento quote session with the Quotation Session.
        $this->_session = $quotationSession;
        $this->tierItemFactory = $tierItemFactory;
        $this->tierItemCollectionFactory = $tierItemCollectionFactory;
        $this->stockStateProvider = $stockStateProvider;
        $productHelper->setSkipSaleableCheck(true);
        $this->quotationDataHelper = $quotationDataHelper;
    }

    /**
     * Update tier items of quotation items
     *
     * @param array $items
     * @return $this
     * @throws \Exception|\Magento\Framework\Exception\LocalizedException
     */
    public function updateTierItems($items)
    {
        return $this->traitUpdateTierItems($items);
    }

    /**
     * Process optional values
     * Set the "on" value to true for saving
     *
     * @param array $tierItems
     * @return array
     */
    protected function processOptionalValues(array $tierItems)
    {
        return $this->traitProcessOptionalValues($tierItems);
    }

    /**
     * Check for allowed custom price value
     *
     * @param array $tierItems
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function processCustomPrice(array $tierItems)
    {
        $this->traitProcessCustomPrice($tierItems);
    }

    /**
     * Process item for quantity check
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param array $tierItems
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function processItems($item, array $tierItems)
    {
        $this->traitProcessItems($item, $tierItems);
    }

    /**
     * Process bundle product for quantity check
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param int $tierItemQty
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function processBundle($item, $tierItemQty)
    {
        $this->traitProcessBundle($item, $tierItemQty);
    }

    /**
     * Process configurable product for quantity check
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param int $tierItemQty
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function processConfigurable($item, $tierItemQty)
    {
        $this->traitProcessConfigurable($item, $tierItemQty);
    }

    /**
     * Check tier quantity for stock settings
     *
     * @param int $productId
     * @param int $qty
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function processQuantity($productId, $qty)
    {
        $this->traitProcessQuantity($productId, $qty);
    }

    /**
     * Process existing tier items
     *
     * @param int $item
     * @param array $info
     * @return \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection
     */
    protected function processExistingTierItems($item, $info)
    {
        return $this->traitProcessExistingTierItems($item, $info);
    }

    /**
     * Process new tier items
     *
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $existingTiers
     * @param array $newTierItems
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection
     */
    protected function processNewTierItems(
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $existingTiers,
        $newTierItems,
        $item
    ) {
        return $this->traitProcessNewTierItems($existingTiers, $newTierItems, $item);
    }

    /**
     * Calculate tier price
     *
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $tierItemCollection
     * @param $quoteItemId
     * @param $selectedTierId
     * @return \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection
     */
    protected function calculateTierPrices(
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $tierItemCollection,
        $quoteItemId,
        $selectedTierId
    ) {
        return $this->traitCalculateTierPrices($tierItemCollection, $quoteItemId, $selectedTierId);
    }

    /**
     * Set the current tier item data to quote item
     *
     * @param \Cart2Quote\Quotation\Model\Quote\TierItem $tierItem
     * @param \Magento\Quote\Model\Quote\Item &$item
     */
    private function setCurrentTierItemData($tierItem, \Magento\Quote\Model\Quote\Item &$item)
    {
        $this->traitSetCurrentTierItemData($tierItem, $item);
    }
}
