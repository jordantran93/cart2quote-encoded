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

namespace Cart2Quote\Quotation\Model\Quote\Pdf;

/**
 * Quotation PDF abstract model
 */
abstract class AbstractPdf extends \Magento\Sales\Model\Order\Pdf\AbstractPdf
{
    use \Cart2Quote\Features\Traits\Model\Quote\Pdf\AbstractPdf {
		getStringUtils as private traitGetStringUtils;
		insertAddress as private traitInsertAddress;
		insertFooter as private traitInsertFooter;
		insertComments as private traitInsertComments;
		insertQuote as private traitInsertQuote;
		insertTotals as private traitInsertTotals;
		drawLineBlocks as private traitDrawLineBlocks;
		_beforeGetPdf as private _traitBeforeGetPdf;
		_afterGetPdf as private _traitAfterGetPdf;
		_drawQuoteItem as private _traitDrawQuoteItem;
		addName as private traitAddName;
		setFont as private traitSetFont;
	}

	/**
     * @var bool
     */
    public $newPage = false;

    /**
     * Predefined constants
     */
    const XML_PATH_SALES_PDF_INVOICE_PACKINGSLIP_ADDRESS = 'sales/identity/address';

    /**
     * Default value of 'y' when new page
     */
    const NEW_PAGE_Y_VALUE = '800';

    /**
     * @param \Magento\Payment\Helper\Data $paymentData
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Sales\Model\Order\Pdf\Config $pdfConfig
     * @param \Magento\Sales\Model\Order\Pdf\Total\Factory $pdfTotalFactory
     * @param \Magento\Sales\Model\Order\Pdf\ItemsFactory $pdfItemsFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
     * @param \Cart2Quote\Quotation\Model\Quote\Address\Renderer $addressRenderer
     * @param Items\QuoteItem $renderer
     * @param array $data
     */
    public function __construct(
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Sales\Model\Order\Pdf\Config $pdfConfig,
        \Magento\Sales\Model\Order\Pdf\Total\Factory $pdfTotalFactory,
        \Magento\Sales\Model\Order\Pdf\ItemsFactory $pdfItemsFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Cart2Quote\Quotation\Model\Quote\Address\Renderer $addressRenderer,
        \Cart2Quote\Quotation\Model\Quote\Pdf\Items\QuoteItem $renderer,
        array $data = []
    ) {
        $this->addressRenderer = $addressRenderer;
        $this->_paymentData = $paymentData;
        $this->_localeDate = $localeDate;
        $this->string = $string;
        $this->_scopeConfig = $scopeConfig;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_rootDirectory = $filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::ROOT);
        $this->_pdfConfig = $pdfConfig;
        $this->_pdfTotalFactory = $pdfTotalFactory;
        $this->_pdfItemsFactory = $pdfItemsFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->_renderer = $renderer;
        parent::__construct(
            $paymentData,
            $string,
            $scopeConfig,
            $filesystem,
            $pdfConfig,
            $pdfTotalFactory,
            $pdfItemsFactory,
            $localeDate,
            $inlineTranslation,
            $addressRenderer,
            $data
        );
    }

    /**
     * get StringUtils Object
     * @return \Magento\Framework\Stdlib\StringUtils
     */
    public function getStringUtils()
    {
        return $this->traitGetStringUtils();
    }

    /**
     * Insert address to pdf page
     *
     * @param \Zend_Pdf_Page &$page
     * @param null $store
     * @return void
     */
    protected function insertAddress(&$page, $store = null)
    {
        $this->traitInsertAddress($page, $store);
    }

    /**
     * Insert General comment to PDF
     *
     * @param \Zend_Pdf_Page $page
     * @param $text
     * @throws \Zend_Pdf_Exception
     */
    protected function insertFooter(\Zend_Pdf_Page $page, $text)
    {
        $this->traitInsertFooter($page, $text);
    }

    /**
     * Insert quote comment to PDF
     *
     * @param \Zend_Pdf_Page $page
     * @param $quote
     * @return \Zend_Pdf_Page
     * @throws \Zend_Pdf_Exception
     */
    protected function insertComments(\Zend_Pdf_Page $page, $quote)
    {
        return $this->traitInsertComments($page, $quote);
    }

    /**
     * Insert Quote to pdf page
     *
     * @param \Zend_Pdf_Page &$page
     * @param \Magento\Sales\Model\Order $obj
     * @param bool $putQuoteId
     * @return void
     */
    protected function insertQuote(&$page, $obj, $putQuoteId = true)
    {
        return $this->traitInsertQuote($page, $obj, $putQuoteId);
    }

    /**
     * Insert totals to pdf page
     *
     * @param \Zend_Pdf_Page $page
     * @param \Magento\Sales\Model\AbstractModel $quote
     * @return \Zend_Pdf_Page
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function insertTotals($page, $quote)
    {
        return $this->traitInsertTotals($page, $quote);
    }

    /**
     * Draw lines
     *
     * Draw items array format:
     * lines        array;array of line blocks (required)
     * shift        int; full line height (optional)
     * height       int;line spacing (default 10)
     *
     * line block has line columns array
     *
     * column array format
     * text         string|array; draw text (required)
     * feed         int; x position (required)
     * font         string; font style, optional: bold, italic, regular
     * font_file    string; path to font file (optional for use your custom font)
     * font_size    int; font size (default 7)
     * align        string; text align (also see feed parametr), optional left, right
     * height       int;line spacing (default 10)
     *
     * @param  \Zend_Pdf_Page $page
     * @param  array $draw
     * @param  array $pageSettings
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Zend_Pdf_Page
     */
    public function drawLineBlocks(\Zend_Pdf_Page $page, array $draw, array $pageSettings = [])
    {
        return $this->traitDrawLineBlocks($page, $draw, $pageSettings);
    }

    /**
     * Before getPdf processing
     *
     * @return void
     */
    protected function _beforeGetPdf()
    {
        $this->_traitBeforeGetPdf();
    }

    /**
     * After getPdf processing
     *
     * @return void
     */
    protected function _afterGetPdf()
    {
        $this->_traitAfterGetPdf();
    }

    /**
     * Draw Quote Item process
     *
     * @param \Magento\Framework\DataObject $item
     * @param \Zend_Pdf_Page $page
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return \Zend_Pdf_Page
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _drawQuoteItem(
        \Magento\Framework\DataObject $item,
        \Zend_Pdf_Page $page,
        \Cart2Quote\Quotation\Model\Quote $quote
    ) {
        return $this->_traitDrawQuoteItem($item, $page, $quote);
    }

    /**
     * Add name to the top.
     *
     * @param $page
     * @param $quote
     * @param $top
     * @return int
     */
    private function addName(&$page, $quote, $top)
    {
        return $this->traitAddName($page, $quote, $top);
    }

    /**
     * Set page font.
     *
     * column array format
     * font         string; font style, optional: bold, italic, regular
     * font_file    string; path to font file (optional for use your custom font)
     * font_size    int; font size (default 10)
     *
     * @param \Zend_Pdf_Page $page
     * @param array $column
     * @return \Zend_Pdf_Resource_Font
     * @throws \Zend_Pdf_Exception
     */
    private function setFont($page, &$column)
    {
        return $this->traitSetFont($page, $column);
    }
}
