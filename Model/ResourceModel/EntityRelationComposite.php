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

namespace Cart2Quote\Quotation\Model\ResourceModel;

/**
 * Class EntityRelationComposite
 */
class EntityRelationComposite
{
    use \Cart2Quote\Features\Traits\Model\ResourceModel\EntityRelationComposite {
		processRelations as private traitProcessRelations;
	}

	/**
     * @var array
     */
    protected $relationProcessors;

    /**
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param array $relationProcessors
     */
    public function __construct(
        \Magento\Framework\Event\ManagerInterface $eventManager,
        array $relationProcessors = []
    ) {
        $this->eventManager = $eventManager;
        $this->relationProcessors = $relationProcessors;
    }

    /**
     * @param \Magento\Sales\Model\AbstractModel $object
     * @return void
     */
    public function processRelations(\Magento\Sales\Model\AbstractModel $object)
    {
        $this->traitProcessRelations($object);
    }
}
