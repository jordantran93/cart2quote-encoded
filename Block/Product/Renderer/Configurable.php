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

namespace Cart2Quote\Quotation\Block\Product\Renderer;

/**
 * Class Configurable
 * @package Cart2Quote\Quotation\Block\Product\Renderer
 */
class Configurable extends \Magento\Swatches\Block\Product\Renderer\Configurable
{
    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    private $quotationHelper;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * Configurable constructor.
     * @param \Cart2Quote\Quotation\Helper\Data $quotationHelper
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils $arrayUtils
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\ConfigurableProduct\Helper\Data $helper
     * @param \Magento\Catalog\Helper\Product $catalogProduct
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\ConfigurableProduct\Model\ConfigurableAttributeData $configurableAttributeData
     * @param \Magento\Swatches\Helper\Data $swatchHelper
     * @param \Magento\Swatches\Helper\Media $swatchMediaHelper
     * @param array $data
     * @param null $swatchAttributesProvider
     */
    public function __construct(
        \Cart2Quote\Quotation\Helper\Data $quotationHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\ConfigurableProduct\Helper\Data $helper,
        \Magento\Catalog\Helper\Product $catalogProduct,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\ConfigurableProduct\Model\ConfigurableAttributeData $configurableAttributeData,
        \Magento\Swatches\Helper\Data $swatchHelper,
        \Magento\Swatches\Helper\Media $swatchMediaHelper,
        array $data = [],
        $swatchAttributesProvider = null
    ) {
        //the class \Magento\Swatches\Model\SwatchAttributesProvider does not exist in Magento 2.1.5
        if (!class_exists(\Magento\Swatches\Model\SwatchAttributesProvider::class)) {
            parent::__construct(
                $context,
                $arrayUtils,
                $jsonEncoder,
                $helper,
                $catalogProduct,
                $currentCustomer,
                $priceCurrency,
                $configurableAttributeData,
                $swatchHelper,
                $swatchMediaHelper,
                $data
            );
        } else {
            parent::__construct(
                $context,
                $arrayUtils,
                $jsonEncoder,
                $helper,
                $catalogProduct,
                $currentCustomer,
                $priceCurrency,
                $configurableAttributeData,
                $swatchHelper,
                $swatchMediaHelper,
                $data,
                $swatchAttributesProvider
            );
        }
        $this->quotationHelper = $quotationHelper;
        $this->customerSession = $customerSession;
    }

    /**
     * @return array
     */
    protected function _getAdditionalConfig()
    {
        $config = parent::_getAdditionalConfig();
        $config['dynamic_add_buttons'] = $this->quotationHelper->isDynamicAddButtonsEnabled();
        foreach ($this->getAllowProducts() as $product) {
            $config['is_saleable'][$product->getId()] = $product->isSaleable();
            $config['is_quotable'][$product->getId()] = $this->quotationHelper->isQuotable(
                $product,
                $this->customerSession->getCustomerGroupId()
            );
        }

        return $config;
    }

    /**
     * @return \Magento\Catalog\Model\Product[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllowProducts()
    {
        if (!$this->hasAllowProducts()) {
            $products = [];
            $allProducts = $this->getProduct()->getTypeInstance()->getUsedProducts($this->getProduct(), null);
            foreach ($allProducts as $product) {
                $products[] = $product;
            }
            $this->setAllowProducts($products);
        }

        return $this->getData('allow_products');
    }

    /**
     * @return bool|int|null
     */
    protected function getCacheLifetime()
    {
        return \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable::getCacheLifetime();
    }
}
