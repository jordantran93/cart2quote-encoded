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

namespace Cart2Quote\Quotation\Model\Quote\Item;

/**
 * Class Section
 * @package Cart2Quote\Quotation\Model\Quote\Item
 */
class Section extends \Magento\Framework\Model\AbstractExtensibleModel implements \Cart2Quote\Quotation\Api\Data\Quote\Item\SectionInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Item\Section {
		getSectionId as private traitGetSectionId;
		getSectionItemId as private traitGetSectionItemId;
		getItemId as private traitGetItemId;
		getSortOrder as private traitGetSortOrder;
		setSectionId as private traitSetSectionId;
		setItemId as private traitSetItemId;
		setSortOrder as private traitSetSortOrder;
		_construct as private _traitConstruct;
	}

	/**
     * @return int
     */
    public function getSectionId()
    {
        return $this->traitGetSectionId();
    }

    /**
     * @return int
     */
    public function getSectionItemId()
    {
        return $this->traitGetSectionItemId();
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->traitGetItemId();
    }

    /**
     * @return int
     */
    public function getSortOrder()
    {
        return $this->traitGetSortOrder();
    }

    /**
     * @param int $sectionId
     * @return $this
     */
    public function setSectionId($sectionId)
    {
        return $this->traitSetSectionId($sectionId);
    }

    /**
     * @param int $itemId
     * @return $this
     */
    public function setItemId($itemId)
    {
        return $this->traitSetItemId($itemId);
    }

    /**
     * @param string $sortOrder
     * @return $this
     */
    public function setSortOrder($sortOrder)
    {
        return $this->traitSetSortOrder($sortOrder);
    }

    /**
     * Init resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }
}
