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

namespace Cart2Quote\Quotation\Model\Quote\Relation;

use Magento\Framework\Model\ResourceModel\Db\VersionControl\RelationInterface;

class TierItem implements RelationInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Relation\TierItem {
		processRelation as private traitProcessRelation;
		isQuotation as private traitIsQuotation;
		hasCurrentTierItemId as private traitHasCurrentTierItemId;
		processExistingUpdatedQuoteItem as private traitProcessExistingUpdatedQuoteItem;
		processNewTierItems as private traitProcessNewTierItems;
	}

	/**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory
     */
    protected $tierItemCollectionFactory;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote\TierItemFactory
     */
    protected $tierItemFactory;

    /**
     * AddProduct constructor.
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory
     * @param \Cart2Quote\Quotation\Model\Quote\TierItemFactory $tierItemFactory
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\CollectionFactory $tierItemCollectionFactory,
        \Cart2Quote\Quotation\Model\Quote\TierItemFactory $tierItemFactory
    ) {
        $this->tierItemCollectionFactory = $tierItemCollectionFactory;
        $this->tierItemFactory = $tierItemFactory;
    }


    /**
     * Process object relations
     *
     * @param \Magento\Framework\Model\AbstractModel|\Magento\Quote\Model\Quote $object
     * @return void
     */
    public function processRelation(\Magento\Framework\Model\AbstractModel $object)
    {
        $this->traitProcessRelation($object);
    }

    /**
     * Check if the quote is a quotation quote
     *
     * @param $object
     * @return bool
     */
    protected function isQuotation($object)
    {
        return $this->traitIsQuotation($object);
    }

    /**
     * Checks if the item has current tier item id
     *
     * @param $item
     * @return bool
     */
    protected function hasCurrentTierItemId($item)
    {
        return $this->traitHasCurrentTierItemId($item);
    }

    /**
     * Process existing quote item that has been updated (different configuration)
     *
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection $existingTierItemCollection
     * @param \Magento\Quote\Model\Quote\Item $item
     */
    protected function processExistingUpdatedQuoteItem(&$existingTierItemCollection, &$item)
    {
        $this->traitProcessExistingUpdatedQuoteItem($existingTierItemCollection, $item);
    }

    /**
     * Process new tiers
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     */
    protected function processNewTierItems(&$item)
    {
        $this->traitProcessNewTierItems($item);
    }
}
