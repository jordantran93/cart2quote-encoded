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
 */

namespace Cart2Quote\Quotation\Helper;

/**
 * Class ProductThumbnail
 * @package Cart2Quote\Quotation\Helper
 */
class ProductThumbnail extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to configuration setting Show Thumb Nail in Request Mail
     */
    const XML_PATH_SHOW_THUMB_NAIL_REQUEST = "cart2quote_email/quote_request/product_thumbnail";
    /**
     * Path to configuration setting Show Thumb Nail in Proposal Mail
     */
    const XML_PATH_SHOW_THUMB_NAIL_PROPOSAL = "cart2quote_email/quote_proposal/product_thumbnail";
    /**
     * Path to configuration setting Show Thumb Nail in Proposal Mail
     */
    const XML_PATH_SHOW_THUMB_NAIL_PDF = "cart2quote_pdf/quote/product_thumbnail";
    /**
     * @var \Magento\Catalog\Helper\Product
     */
    protected $productHelper;

    /**
     * ProductThumbnail constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->productHelper = $productHelper;
        parent::__construct($context);
    }
    /**
     * Is the Product Thumbnail enabled for the Request Email
     * @return bool
     */
    public function showProductThumbnailRequest()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SHOW_THUMB_NAIL_REQUEST,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is the Product Thumbnail enabled for the Proposal Email
     * @return bool
     */
    public function showProductThumbnailProposal()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SHOW_THUMB_NAIL_PROPOSAL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is the Product Thumbnail enabled for the PDF
     * @return bool
     */
    public function showProductThumbnailPdf()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_SHOW_THUMB_NAIL_PDF,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the Product Thumbnail for Request Email
     * @param $product
     * @return string
     */
    public function getProductThumbnail($product)
    {
        return $this->productHelper->getThumbnailUrl($product);
    }
}
