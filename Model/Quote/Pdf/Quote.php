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
 * Quote PDF model
 */
class Quote extends \Cart2Quote\Quotation\Model\Quote\Pdf\AbstractPdf
{
    use \Cart2Quote\Features\Traits\Model\Quote\Pdf\Quote {
		setPdf as private traitSetPdf;
		createQuotePdf as private traitCreateQuotePdf;
		getPdf as private traitGetPdf;
		getQuotes as private traitGetQuotes;
		setQuotes as private traitSetQuotes;
		_drawSectionHeader as private _traitDrawSectionHeader;
		drawLineBlocks as private traitDrawLineBlocks;
		_drawHeader as private _traitDrawHeader;
		drawDisclaimer as private traitDrawDisclaimer;
		getIncrementId as private traitGetIncrementId;
		setPdfLocale as private traitSetPdfLocale;
	}

	/**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var \Cart2Quote\Quotation\Model\Quote\Address\Renderer|\Magento\Sales\Model\Order\Address\Renderer
     */
    protected $_addressRenderer;
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $localeResolver;
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
    /**
     * @var array
     */
    protected $quotes;

    /**
     * @var \Magento\Framework\Translate
     */
    protected $translate;

    /**
     * Quote constructor.
     * @param \Magento\Framework\Translate $translate
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
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     * @param Items\QuoteItem $renderer
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Translate $translate,
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
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Locale\ResolverInterface $localeResolver,
        \Cart2Quote\Quotation\Model\Quote\Pdf\Items\QuoteItem $renderer,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        array $data = []
    ) {
        $this->translate = $translate;
        $this->fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->localeResolver = $localeResolver;
        $this->_addressRenderer = $addressRenderer;
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
            $renderer,
            $data
        );
    }

    /**
     * Set Pdf model
     *
     * @param  \Cart2Quote\Quotation\Model\Quote\Pdf\AbstractPdf $pdf
     * @return $this
     */
    public function setPdf(\Cart2Quote\Quotation\Model\Quote\Pdf\AbstractPdf $pdf)
    {
        return $this->traitSetPdf($pdf);
    }

    /**
     * Creates the Quote PDF and return the filepath
     *
     * @param array $quotes
     * @return string|null
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function createQuotePdf(array $quotes)
    {
        return $this->traitCreateQuotePdf($quotes);
    }

    /**
     * Get PDF document
     * @return \Zend_Pdf
     * @internal param array|\Cart2Quote\Quotation\Traits\Model\Quote\Pdf\Collection $quotes
     */
    public function getPdf()
    {
        return $this->traitGetPdf();
    }

    /**
     * Get array of quotes
     *
     * @return array
     */
    public function getQuotes()
    {
        return $this->traitGetQuotes();
    }

    /**
     * Set array of quotes
     *
     * @param array $quotes
     * @return $this
     * @throws \Exception
     */
    public function setQuotes(array $quotes)
    {
        return $this->traitSetQuotes($quotes);
    }

    /**
     * @param \Zend_Pdf_Page $page
     * @param \Cart2Quote\Quotation\Api\Data\Quote\SectionInterface $section
     * @return \Zend_Pdf_Page
     */
    protected function _drawSectionHeader(
        \Zend_Pdf_Page $page,
        \Cart2Quote\Quotation\Api\Data\Quote\SectionInterface $section
    ) {
        return $this->_traitDrawSectionHeader($page, $section);
    }

    /**
     * @param \Zend_Pdf_Page $page
     * @param array $draw
     * @param array $pageSettings
     * @return \Zend_Pdf_Page
     */
    public function drawLineBlocks(\Zend_Pdf_Page $page, array $draw, array $pageSettings = [])
    {
        return $this->traitDrawLineBlocks($page, $draw, $pageSettings);
    }

    /**
     * Draw header for item table
     *
     * @param \Zend_Pdf_Page $page
     * @return void
     */
    protected function _drawHeader(\Zend_Pdf_Page $page)
    {
        $this->_traitDrawHeader($page);
    }

    /**
     * @param \Zend_Pdf_Page $page
     * @param $quote
     */
    public function drawDisclaimer(\Zend_Pdf_Page $page, $quote)
    {
        $this->traitDrawDisclaimer($page, $quote);
    }

    /**
     * Get array of increments
     *
     * @param array $quotes
     * @return string
     */
    public function getIncrementId(array $quotes)
    {
        return $this->traitGetIncrementId($quotes);
    }

    /**
     * Set the correct store locale to the PDF
     *
     * @param int $storeId
     */
    public function setPdfLocale($storeId)
    {
        $this->traitSetPdfLocale($storeId);
    }
}
