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
 * Factory class for @see \Cart2Quote\Quotation\Model\Quote\TierItem
 */
class TierItemFactory
{
    use \Cart2Quote\Features\Traits\Model\Quote\TierItemFactory {
		createFromItems as private traitCreateFromItems;
		createFromItem as private traitCreateFromItem;
		bundleChildrenAreSaved as private traitBundleChildrenAreSaved;
		create as private traitCreate;
		processNewTierItems as private traitProcessNewTierItems;
	}

	/**
     * Object Manager instance
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = '\\Cart2Quote\\Quotation\\Model\\Quote\\TierItem'
    ) {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create tier items for array of \Magento\Quote\Model\Quote\Item items.
     * @param $items
     * @return array
     */
    public function createFromItems($items)
    {
        return $this->traitCreateFromItems($items);
    }

    /**
     * Create a tier item from item
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param null $qty
     * @return tierItem|bool
     */
    public function createFromItem(\Magento\Quote\Model\Quote\Item $item, $qty = null)
    {
        return $this->traitCreateFromItem($item, $qty);
    }

    /**
     * Check if the children of the bundle are saved before adding tiers
     *
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return bool
     */
    protected function bundleChildrenAreSaved(\Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitBundleChildrenAreSaved($item);
    }

    /**
     * Create class instance with specified parameters
     * @param array $data
     * @return \Cart2Quote\Quotation\Model\Quote\TierItem
     */
    public function create(array $data = [])
    {
        return $this->traitCreate($data);
    }

    /**
     * Process new tier items
     *
     * @param array $newTierItems
     * @param \Magento\Quote\Model\Quote\Item $item
     * @return array
     */
    public function processNewTierItems(array $newTierItems, \Magento\Quote\Model\Quote\Item $item)
    {
        return $this->traitProcessNewTierItems($newTierItems, $item);
    }
}
