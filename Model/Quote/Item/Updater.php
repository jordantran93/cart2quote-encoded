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
 * Class Updater
 * @package Cart2Quote\Quotation\Model\Quote\Item
 */
class Updater extends \Magento\Quote\Model\Quote\Item\Updater
{
    use \Cart2Quote\Features\Traits\Model\Quote\Item\Updater {
		update as private traitUpdate;
		parentConstruct as private traitParentConstruct;
	}

	/**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section
     */
    private $sectionResourceModel;
    /**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section\Loader
     */
    private $sectionsLoader;

    /**
     * Updater constructor.
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section\Loader $sectionsLoader
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section $sectionResourceModel
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Framework\DataObject\Factory $objectFactory
     * @param null $serializer
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section\Loader $sectionsLoader,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section $sectionResourceModel,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Framework\DataObject\Factory $objectFactory,
        $serializer = null
    ) {
        $this->parentConstruct($productFactory, $localeFormat, $objectFactory, $serializer);
        $this->sectionResourceModel = $sectionResourceModel;
        $this->sectionsLoader = $sectionsLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function update(\Magento\Quote\Model\Quote\Item $item, array $info)
    {
        return $this->traitUpdate($item, $info);
    }

    /**
     * Magento updated the constructor with the serializer parameter in version 2.2.0
     * this function is a fix for the error: "Extra parameters passed to parent construct: $serializer."
     *
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Framework\DataObject\Factory $objectFactory
     * @param $serializer
     */
    protected function parentConstruct(
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Framework\DataObject\Factory $objectFactory,
        $serializer
    ) {
        $this->traitParentConstruct($productFactory, $localeFormat, $objectFactory, $serializer);
    }
}
