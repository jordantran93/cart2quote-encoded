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

namespace Cart2Quote\Quotation\Block\Quote\Email\Items;

/**
 * Class Bundle
 * @package Cart2Quote\Quotation\Block\Quote\Email\Items
 */
class Bundle extends \Magento\Bundle\Block\Sales\Order\Items\Renderer
{
    /**
     * @var \Cart2Quote\Quotation\Helper\Data
     */
    protected $quotationHelper;

    /**
     * @var \Cart2Quote\Quotation\Block\Quote\TierItem
     */
    protected $tierItemBlock;

    /**
     * Bundle constructor.
     * @param \Cart2Quote\Quotation\Block\Quote\TierItem $tierItemBlock
     * @param \Cart2Quote\Quotation\Helper\Data $quotationHelper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory
     * @param array $data
     */
    public function __construct(
        \Cart2Quote\Quotation\Block\Quote\TierItem $tierItemBlock,
        \Cart2Quote\Quotation\Helper\Data $quotationHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Model\Product\OptionFactory $productOptionFactory,
        array $data = []
    ) {
        $this->tierItemBlock = $tierItemBlock;
        $this->quotationHelper = $quotationHelper;

        parent::__construct($context, $string, $productOptionFactory, $data);
    }

    /**
     * Check if hide request email item price
     *
     * @return boolean
     */
    public function hidePrice()
    {
        return $this->quotationHelper->isHideEmailRequestPrice();
    }

    /**
     * @return string
     */
    public function getPriceHtml()
    {
        return $this->tierItemBlock->getItemHtml($this->getItem(), 'price');
    }
}
