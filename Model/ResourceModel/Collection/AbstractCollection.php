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

namespace Cart2Quote\Quotation\Model\ResourceModel\Collection;

/**
 * Flat sales abstract collection
 */
abstract class AbstractCollection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Collection\AbstractCollection {
		getSelectCountSql as private traitGetSelectCountSql;
		setSelectCountSql as private traitSetSelectCountSql;
		addAttributeToSelect as private traitAddAttributeToSelect;
		_attributeToField as private _traitAttributeToField;
		addAttributeToFilter as private traitAddAttributeToFilter;
		addAttributeToSort as private traitAddAttributeToSort;
		setPage as private traitSetPage;
		getAllIds as private traitGetAllIds;
		_getAllIdsSelect as private _traitGetAllIdsSelect;
		getSearchCriteria as private traitGetSearchCriteria;
		setSearchCriteria as private traitSetSearchCriteria;
		getTotalCount as private traitGetTotalCount;
		setTotalCount as private traitSetTotalCount;
		setItems as private traitSetItems;
		fetchItem as private traitFetchItem;
		loadWithFilter as private traitLoadWithFilter;
	}

	/**
     * @var \Zend_Db_Select
     */
    protected $_countSelect;

    /**
     * @var \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot
     */
    protected $entitySnapshot;

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource
     * @throws \Zend_Exception
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\Model\ResourceModel\Db\VersionControl\Snapshot $entitySnapshot,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->entitySnapshot = $entitySnapshot;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * get select count sql
     * @return \Zend_Db_Select
     */
    public function getSelectCountSql()
    {
        return $this->traitGetSelectCountSql();
    }

    /**
     * Set select count sql
     * @param \Zend_Db_Select $countSelect
     * @return $this
     */
    public function setSelectCountSql(\Zend_Db_Select $countSelect)
    {
        return $this->traitSetSelectCountSql($countSelect);
    }

    /**
     * Add attribute to select result set.
     * Backward compatibility with EAV collection
     * @param string $attribute
     * @return $this
     */
    public function addAttributeToSelect($attribute)
    {
        return $this->traitAddAttributeToSelect($attribute);
    }

    /**
     * Check if $attribute is \Magento\Eav\Model\Entity\Attribute and convert to string field name
     * @param string|\Magento\Eav\Model\Entity\Attribute $attribute
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _attributeToField($attribute)
    {
        return $this->_traitAttributeToField($attribute);
    }

    /**
     * Specify collection select filter by attribute value
     * Backward compatibility with EAV collection
     * @param string|\Magento\Eav\Model\Entity\Attribute $attribute
     * @param array|int|string|null $condition
     * @return $this
     */
    public function addAttributeToFilter($attribute, $condition = null)
    {
        return $this->traitAddAttributeToFilter($attribute, $condition);
    }

    /**
     * Specify collection select order by attribute value
     * Backward compatibility with EAV collection
     * @param string $attribute
     * @param string $dir
     * @return $this
     */
    public function addAttributeToSort($attribute, $dir = 'asc')
    {
        return $this->traitAddAttributeToSort($attribute, $dir);
    }

    /**
     * Set collection page start and records to show
     * Backward compatibility with EAV collection
     * @param int $pageNum
     * @param int $pageSize
     * @return $this
     */
    public function setPage($pageNum, $pageSize)
    {
        return $this->traitSetPage($pageNum, $pageSize);
    }

    /**
     * Retrieve all ids for collection
     * Backward compatibility with EAV collection
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->traitGetAllIds($limit, $offset);
    }

    /**
     * Create all ids retrieving select with limitation
     * Backward compatibility with EAV collection
     * @param int $limit
     * @param int $offset
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection
     */
    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        return $this->_traitGetAllIdsSelect($limit, $offset);
    }

    /**
     * Get search criteria.
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return $this->traitGetSearchCriteria();
    }

    /**
     * Set search criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->traitSetSearchCriteria($searchCriteria);
    }

    /**
     * Get total count.
     * @return int
     */
    public function getTotalCount()
    {
        return $this->traitGetTotalCount();
    }

    /**
     * Set total count.
     * @param int $totalCount
     * @return $this
     */
    public function setTotalCount($totalCount)
    {
        return $this->traitSetTotalCount($totalCount);
    }

    /**
     * Set items list.
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null)
    {
        return $this->traitSetItems($items);
    }

    /**
     * Returns a collection item that corresponds to the fetched row
     * and moves the internal data pointer ahead
     * All returned rows marked as non changed to prevent unnecessary persistence operations
     * @return  \Magento\Framework\Object|bool
     */
    public function fetchItem()
    {
        return $this->traitFetchItem();
    }

    /**
     * Load data with filter in place
     * All returned rows marked as non changed to prevent unnecessary persistence operations
     * @param   bool $printQuery
     * @param   bool $logQuery
     * @return  $this
     */
    public function loadWithFilter($printQuery = false, $logQuery = false)
    {
        return $this->traitLoadWithFilter($printQuery, $logQuery);
    }
}
