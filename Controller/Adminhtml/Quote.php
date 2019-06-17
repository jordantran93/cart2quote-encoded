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
 *
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 */

namespace Cart2Quote\Quotation\Controller\Adminhtml;

/**
 * Adminhtml quotation quotes controller
 */
abstract class Quote extends \Magento\Backend\App\Action
{
    use \Cart2Quote\Features\Traits\Controller\Adminhtml\Quote {
		_initAction as private _traitInitAction;
		_initQuote as private _traitInitQuote;
		_getSession as private _traitGetSession;
		_isAllowed as private _traitIsAllowed;
		execute as private traitExecute;
		_initSession as private _traitInitSession;
		getCurrentQuote as private traitGetCurrentQuote;
		_processData as private _traitProcessData;
		_processActionData as private _traitProcessActionData;
		_processAddresses as private _traitProcessAddresses;
		_processShipping as private _traitProcessShipping;
		_processFiles as private _traitProcessFiles;
		_updateQuoteItems as private _traitUpdateQuoteItems;
		isDisabledNegativeProfit as private traitIsDisabledNegativeProfit;
		processCurrency as private traitProcessCurrency;
		_removeQuoteItem as private _traitRemoveQuoteItem;
		_setSubtotalProposal as private _traitSetSubtotalProposal;
		_processGiftMessage as private _traitProcessGiftMessage;
		_saveGiftMessage as private _traitSaveGiftMessage;
		_getGiftmessageSaveModel as private _traitGetGiftmessageSaveModel;
		_importGiftMessageAllowQuoteItemsFromProducts as private _traitImportGiftMessageAllowQuoteItemsFromProducts;
		_importGiftMessageAllowQuoteItemsFromItems as private _traitImportGiftMessageAllowQuoteItemsFromItems;
		_reloadQuote as private _traitReloadQuote;
	}

	/**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;
    /**
     * @var \Magento\Framework\Escaper
     */
    protected $escaper;
    /**
     * Array of actions which can be processed without secret key validation
     *
     * @var string[]
     */
    protected $_publicActions = ['view', 'index'];
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $_fileFactory;
    /**
     * @var \Magento\Framework\Translate\InlineInterface
     */
    protected $_translateInline;
    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $helperData;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;
    /**
     * @var \Magento\Framework\Controller\Result\RawFactory
     */
    protected $resultRawFactory;
    /**
     * @var \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory
     */
    protected $quoteFactory;
    /**
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    protected $_currentQuote;

    /**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Status\Collection
     */
    protected $_statusCollection;
    /**
     * Quote Create Model
     *
     * @var \Cart2Quote\Quotation\Model\Admin\Quote\Create
     */
    protected $quoteCreate;
    /**
     * @var \Magento\Store\Model\Store
     */
    protected $store;
    /**
     * @var \Cart2Quote\Quotation\Helper\Cloning
     */
    protected $cloningHelper;

    /**
     * Quote constructor.
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param \Magento\Store\Model\Store $store
     * @param \Magento\Framework\Escaper $escaper
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Translate\InlineInterface $translateInline
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
     * @param \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
     * @param \Cart2Quote\Quotation\Helper\Data $helperData
     * @param \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Status\Collection $statusCollection
     * @param \Cart2Quote\Quotation\Model\Admin\Quote\Create $quoteCreate
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Cart2Quote\Quotation\Helper\Cloning $cloningHelper
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        \Magento\Store\Model\Store $store,
        \Magento\Framework\Escaper $escaper,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Translate\InlineInterface $translateInline,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Cart2Quote\Quotation\Helper\Data $helperData,
        \Cart2Quote\Quotation\Model\QuoteFactory $quoteFactory,
        \Cart2Quote\Quotation\Model\ResourceModel\Status\Collection $statusCollection,
        \Cart2Quote\Quotation\Model\Admin\Quote\Create $quoteCreate,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Cart2Quote\Quotation\Helper\Cloning $cloningHelper
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->store = $store;
        $this->escaper = $escaper;
        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_translateInline = $translateInline;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultRawFactory = $resultRawFactory;
        $this->helperData = $helperData;
        $this->quoteFactory = $quoteFactory;
        $this->_statusCollection = $statusCollection;
        $this->quoteCreate = $quoteCreate;
        $this->scopeConfig = $scopeConfig;
        $this->cloningHelper = $cloningHelper;
        parent::__construct($context);
    }

    /**
     * Init layout, menu and breadcrumb
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        return $this->_traitInitAction();
    }

    /**
     * Initialize quote model instance
     *
     * @return \Cart2Quote\Quotation\Model\Quote|false
     */
    protected function _initQuote()
    {
        return $this->_traitInitQuote();
    }

    /**
     * Retrieve session object
     *
     * @return \Magento\Backend\Model\Session\Quote
     */
    protected function _getSession()
    {
        return $this->_traitGetSession();
    }

    /**
     * Acl check for admin
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_traitIsAllowed();
    }

    /**
     * Quotes grid
     *
     * @return null|\Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        return $this->traitExecute();
    }

    /**
     * Initialize quote creation session data
     *
     * @return $this
     */
    protected function _initSession()
    {
        return $this->_traitInitSession();
    }

    /**
     * Retrieve quote create model
     *
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    protected function getCurrentQuote()
    {
        return $this->traitGetCurrentQuote();
    }

    /**
     * Processing request data
     *
     * @return $this
     */
    protected function _processData()
    {
        return $this->_traitProcessData();
    }

    /**
     * Process request data with additional logic for saving quote and creating order
     *
     * @param string $action
     *
     * @return $this
     */
    protected function _processActionData($action = null)
    {
        return $this->_traitProcessActionData($action);
    }

    /**
     * Function Process the quote addresses
     */
    protected function _processAddresses()
    {
        $this->_traitProcessAddresses();
    }

    /**
     * Function Process the quote shipping method
     */
    protected function _processShipping()
    {
        $this->_traitProcessShipping();
    }

    /**
     * Process buyRequest file options of items
     *
     * @param array $items
     *
     * @return array
     */
    protected function _processFiles($items)
    {
        return $this->_traitProcessFiles($items);
    }

    /**
     * Update the quote items based on the data provided in the post data
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _updateQuoteItems()
    {
        $this->_traitUpdateQuoteItems();
    }

    protected function isDisabledNegativeProfit()
    {
        return $this->traitIsDisabledNegativeProfit();
    }

    /**
     * Set the currency, collected from the post data, on the quote.
     *
     * @return $this;
     */
    protected function processCurrency()
    {
        return $this->traitProcessCurrency();
    }

    /**
     * Remove a quote item based on the post data
     */
    protected function _removeQuoteItem()
    {
        $this->_traitRemoveQuoteItem();
    }

    /**
     * Sets the proposal subtotal
     */
    protected function _setSubtotalProposal()
    {
        $this->_traitSetSubtotalProposal();
    }

    /**
     * Trigers the giftmessage methods
     *
     * @return mixed
     */
    protected function _processGiftMessage()
    {
        return $this->_traitProcessGiftMessage();
    }

    /**
     * Saves Gift message
     */
    protected function _saveGiftMessage()
    {
        $this->_traitSaveGiftMessage();
    }

    /**
     * Retrieve gift message save model
     *
     * @return \Magento\GiftMessage\Model\Save
     */
    protected function _getGiftmessageSaveModel()
    {
        return $this->_traitGetGiftmessageSaveModel();
    }

    /**
     * importAllowQuoteItemsFromProducts
     *
     * @return mixed
     */
    protected function _importGiftMessageAllowQuoteItemsFromProducts()
    {
        return $this->_traitImportGiftMessageAllowQuoteItemsFromProducts();
    }

    /**
     * importAllowQuoteItemsFromItems
     */
    protected function _importGiftMessageAllowQuoteItemsFromItems()
    {
        $this->_traitImportGiftMessageAllowQuoteItemsFromItems();
    }

    /**
     * @return $this
     */
    protected function _reloadQuote()
    {
        return $this->_traitReloadQuote();
    }
}
