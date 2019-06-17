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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem;

/**
 * Class Collection
 * @package Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\TierItem\Collection {
		setItem as private traitSetItem;
		tierExists as private traitTierExists;
		tierExistsForItem as private traitTierExistsForItem;
		getTier as private traitGetTier;
		getTierById as private traitGetTierById;
		getTiersByIds as private traitGetTiersByIds;
		getQtys as private traitGetQtys;
		setItemTiers as private traitSetItemTiers;
		getTierItemsByItemId as private traitGetTierItemsByItemId;
		_construct as private _traitConstruct;
		_afterLoad as private _traitAfterLoad;
	}

	/**
     * @var \Magento\Quote\Model\Quote\Item $_item
     */
    protected $_item;

    /**
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return $this
     */
    public function setItem(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitSetItem($item);
    }

    /**
     * @param $itemId
     * @param $qty
     * @return bool
     */
    public function tierExists($itemId, $qty)
    {
        return $this->traitTierExists($itemId, $qty);
    }

    /**
     * @param $itemId
     * @return bool
     */
    public function tierExistsForItem($itemId)
    {
        return $this->traitTierExistsForItem($itemId);
    }

    /**
     * @param $itemId
     * @param $qty
     * @return \Cart2Quote\Quotation\Model\Quote\TierItem
     */
    public function getTier($itemId, $qty)
    {
        return $this->traitGetTier($itemId, $qty);
    }

    /**
     * @param $tierItemId
     * @return \Cart2Quote\Quotation\Model\Quote\TierItem
     */
    public function getTierById($tierItemId)
    {
        return $this->traitGetTierById($tierItemId);
    }

    /**
     * @param $tierItemIds
     * @return \Cart2Quote\Quotation\Model\ResourceModel\Quote\TierItem\Collection
     */
    public function getTiersByIds($tierItemIds)
    {
        return $this->traitGetTiersByIds($tierItemIds);
    }

    /**
     * Get an array with the ID as key and record qty as value
     *
     * @param bool $format
     * @return array ['ID' => 'qty']
     */
    public function getQtys($format = true)
    {
        return $this->traitGetQtys($format);
    }

    /**
     * Set tier items to a Quote item
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return \Magento\Quote\Model\Quote\Item
     */
    public function setItemTiers(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitSetItemTiers($item);
    }

    /**
     * Get the tier items by id
     *
     * @param $itemId
     * @param bool $orderByQty
     * @return $this
     */
    public function getTierItemsByItemId($itemId, $orderByQty = true)
    {
        return $this->traitGetTierItemsByItemId($itemId, $orderByQty);
    }

    /**
     * Model initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }

    /**
     * @return $this
     */
    protected function _afterLoad()
    {
        return $this->_traitAfterLoad();
    }
}
