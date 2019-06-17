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

namespace Cart2Quote\Quotation\Controller;

/**
 * MoveToQuote controller
 */
abstract class MoveToQuote extends \Magento\Framework\App\Action\Action
{
    /**
     * Scope config
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Checkout Session
     *
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * Quotation Session
     *
     * @var \Cart2Quote\Quotation\Model\Session
     */
    protected $quotationSession;

    /**
     * Store Manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Form Key Validator
     *
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * Quotation Cart
     *
     * @var \Cart2Quote\Quotation\Model\QuotationCart
     */
    protected $cart;

    /**
     * Object Copy Service
     *
     * @var \Magento\Framework\DataObject\Copy
     */
    protected $objectCopyService;

    /**
     * Quote Factory
     *
     * @var \Magento\Quote\Model\QuoteFactory
     */
    protected $quoteFactory;

    /**
     * Quote Model
     *
     * @var \Magento\Quote\Model\Quote
     */
    protected $quote;

    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * MoveToQuote constructor.
     * @param \Cart2Quote\Quotation\Helper\Data $helper
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Cart2Quote\Quotation\Model\QuotationCart $cart
     * @param \Cart2Quote\Quotation\Model\Session $quotationSession
     * @param \Magento\Framework\DataObject\Copy $objectCopyService
     * @param \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     */
    public function __construct(
        \Cart2Quote\Quotation\Helper\Data $helper,
        \Cart2Quote\Quotation\Model\Quote $quote,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Cart2Quote\Quotation\Model\QuotationCart $cart,
        \Cart2Quote\Quotation\Model\Session $quotationSession,
        \Magento\Framework\DataObject\Copy $objectCopyService,
        \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
    ) {
        $this->helper = $helper;
        $this->quote = $quote;
        $this->formKeyValidator = $formKeyValidator;
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->quotationSession = $quotationSession;
        $this->storeManager = $storeManager;
        $this->objectCopyService = $objectCopyService;
        $this->cart = $cart;
        $this->quoteFactory = $quoteFactory;
        $this->quoteRepository = $quoteRepository;
        parent::__construct($context);
    }

    /**
     * @param string $data
     * @return string
     */
    public function getUrl($data = '')
    {
        return $this->_url->getUrl($data);
    }

    /**
     * Clone quote model
     *
     * @return bool|\Magento\Quote\Model\Quote
     * @throws \Exception
     */
    protected function cloneQuote()
    {
        $quote = $this->checkoutSession->getQuote();
        $quotationQuote = $this->quotationSession->getQuote();

        if (!$quote->getId()) {
            $this->messageManager->addErrorMessage(__('This quote no longer exists.'));
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
            return false;
        } else {
            $this->helper->isMoveAllowed($quote);
            $quotationQuote->merge($quote);
            $quotationQuote->collectTotals();
            $quotationQuote->setIsQuotationQuote(1);
            $quotationQuote->save();
            $this->quotationSession->setQuoteId($quotationQuote->getId());

            $quote->removeAllItems();
            $this->quoteRepository->save($quote);
        }

        return $quotationQuote;
    }
}
