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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote\Grid;

/**
 * Flat quotation quote grid collection
 */
class Collection extends \Cart2Quote\Quotation\Model\ResourceModel\Quote\Collection
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\Grid\Collection {
		getSelectCountSql as private traitGetSelectCountSql;
		getIsCustomerMode as private traitGetIsCustomerMode;
		setIsCustomerMode as private traitSetIsCustomerMode;
		_construct as private _traitConstruct;
		_initSelect as private _traitInitSelect;
	}

	/**
     * Event prefix
     * @var string
     */
    protected $_eventPrefix = 'quotation_quote_grid_collection';

    /**
     * Event object
     * @var string
     */
    protected $_eventObject = 'quote_grid_collection';

    /**
     * Customer mode flag
     * @var bool
     */
    protected $_customerModeFlag = false;

    /**
     * Get SQL for get record count
     * @return \Magento\Framework\DB\Select
     */
    public function getSelectCountSql()
    {
        return $this->traitGetSelectCountSql();
    }

    /**
     * Get customer mode flag value
     * @return bool
     */
    public function getIsCustomerMode()
    {
        return $this->traitGetIsCustomerMode();
    }

    /**
     * Set customer mode flag value
     * @param bool $value
     * @return $this
     */
    public function setIsCustomerMode($value)
    {
        return $this->traitSetIsCustomerMode($value);
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
     * Init collection select
     * @return $this
     */
    protected function _initSelect()
    {
        return $this->_traitInitSelect();
    }
}
