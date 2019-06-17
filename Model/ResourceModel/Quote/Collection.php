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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote;

/**
 * Quotes collection
 */
class Collection extends \Magento\Quote\Model\ResourceModel\Quote\Collection
{

    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\Collection {
		getQuote as private traitGetQuote;
		getSearchCriteria as private traitGetSearchCriteria;
		setSearchCriteria as private traitSetSearchCriteria;
		getTotalCount as private traitGetTotalCount;
		setTotalCount as private traitSetTotalCount;
		setItems as private traitSetItems;
		_construct as private _traitConstruct;
		_initSelect as private _traitInitSelect;
	}

	/**
     * @var \Magento\Framework\Api\SearchCriteriaInterface
     */
    protected $searchCriteria;

    /**
     * Get Quotation by Quote Id
     * @param int quote id
     * @return $this
     */
    public function getQuote($quoteId)
    {
        return $this->traitGetQuote($quoteId);
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return $this->traitGetSearchCriteria();
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->traitSetSearchCriteria($searchCriteria);
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->traitGetTotalCount();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this->traitSetTotalCount($totalCount);
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this->traitSetItems($items);
    }

    /**
     * Resource initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }

    /**
     * Init collection select
     * @return $this
     */
    protected function _initSelect()
    {
        return $this->_traitInitSelect();
    }
}
