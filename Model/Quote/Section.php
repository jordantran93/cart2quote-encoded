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
 * Class Section
 * @package Cart2Quote\Quotation\Model\Quote
 */
class Section extends \Magento\Framework\Model\AbstractExtensibleModel implements \Cart2Quote\Quotation\Api\Data\Quote\SectionInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Section {
		getSectionId as private traitGetSectionId;
		getQuoteId as private traitGetQuoteId;
		getLabel as private traitGetLabel;
		getSortOrder as private traitGetSortOrder;
		setSectionId as private traitSetSectionId;
		setQuoteId as private traitSetQuoteId;
		setLabel as private traitSetLabel;
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
    public function getQuoteId()
    {
        return $this->traitGetQuoteId();
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->traitGetLabel();
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
     * @param int $quoteId
     * @return $this
     */
    public function setQuoteId($quoteId)
    {
        return $this->traitSetQuoteId($quoteId);
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        return $this->traitSetLabel($label);
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
