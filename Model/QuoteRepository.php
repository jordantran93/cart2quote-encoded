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

namespace Cart2Quote\Quotation\Model;

/**
 * Class QuoteRepository
 * @package Cart2Quote\Quotation\Model
 */
class QuoteRepository extends \Magento\Quote\Model\QuoteRepository implements \Cart2Quote\Quotation\Api\QuoteRepositoryInterface
{
    use \Cart2Quote\Features\Traits\Model\QuoteRepository {
		get as private traitGet;
		saveQuote as private traitSaveQuote;
		deleteQuote as private traitDeleteQuote;
		getItems as private traitGetItems;
		getQuoteCollection as private traitGetQuoteCollection;
		getCartItemOptionsProcessor as private traitGetCartItemOptionsProcessor;
	}

	/**
     * @var CartItemOptionsProcessor
     */
    private $cartItemOptionsProcessor;

    /**
     * @var \Cart2Quote\Quotation\Model\QuoteFactory
     */
    protected $quotationFactory;

    /**
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * QuoteRepository constructor.
     * @param \Cart2Quote\Quotation\ModelQuoteFactory $quotationFactory
     * @param \Magento\Quote\Model\QuoteFactory $quoteFactory
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\QuoteFactory $quotationFactory,
        \Magento\Quote\Model\QuoteFactory $quoteFactory
    ) {
        $this->quotationFactory = $quotationFactory;
        $this->quoteFactory = $quoteFactory;
    }


    /**
     * @param int $quoteId
     * @param [] $sharedStoreIds
     * @return \Cart2Quote\Quotation\Api\Data\QuoteCartInterface|\Magento\Quote\Api\Data\CartInterface|\Magento\Quote\Model\Quote
     * @throws \Exception
     */
    public function get($quoteId, array $sharedStoreIds = [])
    {
        return $this->traitGet($quoteId, $sharedStoreIds);
    }

    /**
     * @param \Cart2Quote\Quotation\Api\Data\QuoteInterface $quote
     */
    public function saveQuote(\Cart2Quote\Quotation\Api\Data\QuoteInterface $quote)
    {
        $this->traitSaveQuote($quote);
    }

    /**
     * @param int $quoteId
     * @param [] $sharedStoreIds
     * @throws \Exception
     */
    public function deleteQuote($quoteId, array $sharedStoreIds)
    {
        $this->traitDeleteQuote($quoteId, $sharedStoreIds);
    }

    /**
     * @param int $quoteId
     * @return []
     * @throws \Exception
     */
    public function getItems($quoteId)
    {
        return $this->traitGetItems($quoteId);
    }

    /**
     * {@inheritDoc}
     */
    protected function getQuoteCollection()
    {
        return $this->traitGetQuoteCollection();
    }

    /**
     * @return \Magento\Quote\Model\Quote\Item\CartItemOptionsProcessor
     * @deprecated 100.1.0
     */
    private function getCartItemOptionsProcessor()
    {
        return $this->traitGetCartItemOptionsProcessor();
    }
}
