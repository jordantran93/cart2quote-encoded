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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote\Status\History;

/**
 * Flat quotation quote status history collection
 */
class Collection extends \Cart2Quote\Quotation\Model\ResourceModel\Quote\Collection\AbstractCollection implements \Cart2Quote\Quotation\Api\Data\QuoteStatusHistorySearchResultInterface
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\Status\History\Collection {
		getUnnotifiedForInstance as private traitGetUnnotifiedForInstance;
		_construct as private _traitConstruct;
	}

	/**
     * Event prefix
     * @var string
     */
    protected $_eventPrefix = 'quotation_quote_status_history_collection';

    /**
     * Event object
     * @var string
     */
    protected $_eventObject = 'quote_status_history_collection';

    /**
     * Get history object collection for specified instance (quote, shipment, invoice or credit memo)
     * Parameter instance may be one of the following types: \Cart2Quote\Quotation\Model\Quote
     * @param \Magento\Sales\Model\AbstractModel $instance
     * @return \Cart2Quote\Quotation\Model\Quote\Status\History|null
     */
    public function getUnnotifiedForInstance($instance)
    {
        return $this->traitGetUnnotifiedForInstance($instance);
    }

    /**
     * Model initialization
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }
}
