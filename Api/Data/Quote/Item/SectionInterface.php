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

namespace Cart2Quote\Quotation\Api\Data\Quote\Item;

/**
 * Interface SectionInterface
 * @package Cart2Quote\Quotation\Api\Data\Quote\Item
 */
interface SectionInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const SECTION_ITEM_ID = 'section_item_id';
    /**
     *
     */
    const SECTION_ID = "section_id";
    /**
     *
     */
    const ITEM_ID = "item_id";
    /**
     *
     */
    const SORT_ORDER = "sort_order";

    /**
     * @return int
     */
    public function getSectionItemId();

    /**
     * @return int
     */
    public function getSectionId();

    /**
     * @return int
     */
    public function getItemId();

    /**
     * @return int
     */
    public function getSortOrder();

    /**
     * @param int $sectionId
     * @return self
     */
    public function setSectionId($sectionId);

    /**
     * @param int $itemId
     * @return self
     */
    public function setItemId($itemId);

    /**
     * @param string $sortOrder
     * @return self
     */
    public function setSortOrder($sortOrder);
}
