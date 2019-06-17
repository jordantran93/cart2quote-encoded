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

namespace Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section;

use Magento\Framework\App\ResourceConnection;

/**
 * Class Loader
 * @package Cart2Quote\Quotation\Model\ResourceModel\Quote\Section
 */
class Loader
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\Quote\Item\Section\Loader {
		getIdByItemId as private traitGetIdByItemId;
	}

	/** @var  \Magento\Framework\EntityManager\MetadataPool */
    private $metadataPool;

    /** @var  \Magento\Framework\App\ResourceConnection */
    private $resourceConnection;

    /**
     * Loader constructor.
     * @param \Magento\Framework\EntityManager\MetadataPool $metadataPool
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        \Magento\Framework\EntityManager\MetadataPool $metadataPool,
        ResourceConnection $resourceConnection
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $itemId
     * @return int
     * @throws \Exception
     */
    public function getIdByItemId($itemId)
    {
        return $this->traitGetIdByItemId($itemId);
    }
}
