<?php
/**
 * CART2QUOTE CONFIDENTIAL
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
 *
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 *
 */

namespace Cart2Quote\Quotation\Helper;

/**
 * Class Cloning
 *
 * @package Cart2Quote\Quotation\Helper
 */
class Cloning extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Quote\Model\ResourceModel\Quote\Item
     */
    private $itemResourceModel;

    /**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section
     */
    private $sectionResourceModel;

    /**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section
     */
    private $sectionItemResourceModel;

    /**
     * @var \Cart2Quote\Quotation\Model\QuoteFactory
     */
    private $quoteFactory;

    /**
     * @var array
     */
    protected $sectionsMapping = [];

    /**
     * Cloning constructor.
     *
     * @param \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory
     * @param \Magento\Quote\Model\ResourceModel\Quote\Item $itemResourceModel
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section $sectionResourceModel
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section $sectionItemResourceModel
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory,
        \Magento\Quote\Model\ResourceModel\Quote\Item $itemResourceModel,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\Section $sectionResourceModel,
        \Cart2Quote\Quotation\Model\ResourceModel\Quote\Item\Section $sectionItemResourceModel,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->itemResourceModel = $itemResourceModel;
        $this->sectionResourceModel = $sectionResourceModel;
        $this->sectionItemResourceModel = $sectionItemResourceModel;
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function cloneQuote(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        $newQuote = $this->createNewQuote($quote);
        $this->addSections($quote->getExtensionAttributes()->getSections(), $newQuote);
        $this->addItems($quote->getAllVisibleItems(), $newQuote);
        $this->addAddresses($quote->getAddressesCollection(), $newQuote);
        $this->addPayments($quote->getPaymentsCollection(), $newQuote);
        $this->addShippingMethod($quote->getShippingAddress()->getShippingMethod(), $newQuote);
        $newQuote->collectShippingRates();
        $newQuote->setRecollect(true);
        $newQuote->saveQuote();
        $this->sectionsMapping = [];

        return $newQuote;
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     * @throws \Exception
     */
    private function createNewQuote($quote)
    {
        $newQuote = $this->quoteFactory->create();
        $excludeFromCopy = [
            'id',
            'increment_id',
            'quotation_created_at',
            'entity_id',
            'quote_id'
        ];
        $data = array_diff_key($quote->getData(), array_flip($excludeFromCopy));
        $newQuote->setData($data);
        $newQuote->save();

        return $newQuote;
    }

    /**
     * @param \Cart2Quote\Quotation\Api\Data\Quote\SectionInterface[] $originalSections
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     *
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function addSections($originalSections, $quote)
    {
        $this->sectionsMapping = $sections = [];
        foreach ($originalSections as $originalSection) {
            $clonedSection = clone $originalSection;
            $clonedSection->setId(null);
            $clonedSection->setSectionId(null);
            $clonedSection->setQuoteId($quote->getQuoteId());
            $this->sectionResourceModel->save($clonedSection);
            $this->sectionsMapping[$originalSection->getSectionId()] = $clonedSection->getSectionId();
            $sections[] = $clonedSection;
        }
        $quote->getExtensionAttributes()->setSections($sections);
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item[] $items
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     *
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    private function addItems($items, $quote)
    {
        /**
         * @var \Magento\Quote\Model\Quote\Item $item
         */
        foreach ($items as $item) {
            $item->setQuote($quote);
            $sectionItemItemId = $item->getExtensionAttributes()->getSection()->getSectionId();
            if (isset($this->sectionsMapping[$sectionItemItemId])) {
                $cloneItem = $this->cloneItem($item, false, $this->sectionsMapping[$sectionItemItemId]);
            } else {
                $cloneItem = $this->cloneItem($item, false, null);
            }
            $quote->getItemsCollection()->addItem($cloneItem);
        }
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address[] $addresses
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     */
    private function addAddresses($addresses, $quote)
    {
        $quote->getAddressesCollection()->removeAllItems();
        foreach ($addresses as $key => $address) {
            $clonedAddress = clone $address;
            $clonedAddress->setId(null);
            $clonedAddress->setQuote($quote);
            $clonedAddress->setPreviousId($address->getId());
            $clonedAddress->setPreviousQuoteId($address->getQuoteId());
            $quote->addAddress($clonedAddress);
        }
    }

    /**
     * @param \Magento\Quote\Model\Quote\Payment[] $payments
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     */
    private function addPayments($payments, $quote)
    {
        $quote->getPaymentsCollection()->removeAllItems();
        foreach ($payments as $payment) {
            $clonedPayment = clone $payment;
            $clonedPayment->setId(null);
            $clonedPayment->setQuote($quote);
            $clonedPayment->setPreviousId($payment->getId());
            $clonedPayment->setPreviousQuoteId($payment->getQuoteId());
            $quote->setPayment($clonedPayment);
        }
    }

    /**
     * @param \Magento\Quote\Model\Quote\Item $item
     * @param int|null $sectionItemId
     *
     * @return \Magento\Quote\Model\Quote\Item
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function cloneItem(
        \Magento\Quote\Model\Quote\Item $item,
        $useOrignalSectionItem = true,
        $sectionItemId = null,
        $parentItem = null
    ) {
        $clonedItem = clone $item;
        $clonedItem->setId(null);
        $clonedItem->setQuote($item->getQuote());
        $clonedItem->setParentItemId(null);

        $options = $item->getOptions();
        foreach ($options as $option) {
            $clonedOption = clone $option;
            $clonedOption->setOptionId(null);
            $clonedOption->setItemId(null);
            $clonedItem->setOptions($clonedOption);
        }

        if ($item->getTierItems()) {
            $clonedItem->setTierItem(null);
            $clonedItem->setTierItems($item->getTierItems());
            $clonedItem->setCurrentTierItemId(null);
            $clonedItem->setCurrentTierItem(null);
        }

        if (isset($parentItem)) {
            $clonedItem->setParentItem($parentItem);
        }

        $this->itemResourceModel->save($clonedItem);

        foreach ($item->getChildren() as $childItem) {
            $childItem->setQuote($clonedItem->getQuote());
            $this->cloneItem($childItem, $useOrignalSectionItem, $sectionItemId, $clonedItem);
        }

        /**
         * @var \Cart2Quote\Quotation\Model\Quote\TierItem $tierItem
         */
        foreach ($clonedItem->getTierItems() as $tierItem) {
            $tierItem->setId(null);
            $tierItem->setItemId($clonedItem->getItemId());
            $tierItem->setItem($clonedItem);
            $tierItem->save();
        }

        /**
         * @var \Cart2Quote\Quotation\Model\Quote\Item\Section $originalItemSection
         */
        $originalItemSection = $item->getExtensionAttributes()->getSection();
        if ($originalItemSection->getSectionId()) {
            $clonedItemSection = clone $originalItemSection;
            $clonedItemSection->setId(null);
            if ($useOrignalSectionItem) {
                $sectionItemId = $originalItemSection->getSectionId();
            }
            $clonedItemSection->setSectionId($sectionItemId);
            $clonedItemSection->setItemId($clonedItem->getItemId());
            $this->sectionItemResourceModel->save($clonedItemSection);
        }

        return $clonedItem;
    }

    /**
     * @param string $shippingMethod
     * @param \Cart2Quote\Quotation\Model\Quote $newQuote
     */
    private function addShippingMethod($shippingMethod, $newQuote)
    {
        $newQuote->getShippingAddress()->setShippingMethod($shippingMethod);
    }
}
