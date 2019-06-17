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

namespace Cart2Quote\Quotation\Model\Quote\Pdf\Items;

/**
 * Class Quote
 * @package Cart2Quote\Quotation\Model\Sales\Quote\Pdf\Items
 */
class QuoteItem extends AbstractItems
{
    use \Cart2Quote\Features\Traits\Model\Quote\Pdf\Items\QuoteItem {
		draw as private traitDraw;
		getQuoteItemOptions as private traitGetQuoteItemOptions;
		setTierItemsPdf as private traitSetTierItemsPdf;
	}

	/**
     * Directory structure for Product Images
     */
    const CATALOG_PRODUCT_PATH = '/catalog/product';
    /**
     * Feed distance for Item Price
     */
    const PRICE_FEED = 360;
    /**
     * Feed distance Item Qty
     */
    const QTY_FEED = 420;
    /**
     * Feed distance for Item Tax
     */
    const TAX_FEED = 490;
    /**
     * Feed distance Item Row Total
     */
    const ROW_TOTAL_FEED = 560;

    /**
     * Interface to get information about products
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepositoryInterface;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $cart2QuoteHelper;

    /**
     * @var \Cart2Quote\Quotation\Helper\ProductThumbnail
     */
    protected $thumbnailHelper;

    /**
     * QuoteItem constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Tax\Helper\Data $taxData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\Framework\Filter\FilterManager $filterManager
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Cart2Quote\Quotation\Helper\Data $cart2QuoteHelper
     * @param \Cart2Quote\Quotation\Helper\ProductThumbnail $thumbnailHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Tax\Helper\Data $taxData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Framework\Filter\FilterManager $filterManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepositoryInterface,
        \Cart2Quote\Quotation\Helper\Data $cart2QuoteHelper,
        \Cart2Quote\Quotation\Helper\ProductThumbnail $thumbnailHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->_scopeConfig = $scopeConfig;
        $this->productRepositoryInterface = $productRepositoryInterface;
        $this->cart2QuoteHelper = $cart2QuoteHelper;
        $this->thumbnailHelper = $thumbnailHelper;
        parent::__construct(
            $context,
            $registry,
            $taxData,
            $filesystem,
            $filterManager,
            $resource,
            $resourceCollection,
            $data
        );
    }

    /**
     * Draw item line
     *
     * @return void
     */
    public function draw()
    {
        $this->traitDraw();
    }

    /**
     * Get Selected Custom Options from a Product
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getQuoteItemOptions()
    {
        return $this->traitGetQuoteItemOptions();
    }

    /**
     * Set the tier quantity to PDF
     *
     * @param $quote
     * @param $item
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setTierItemsPdf($quote, $item)
    {
        return $this->traitSetTierItemsPdf($quote, $item);
    }
}
