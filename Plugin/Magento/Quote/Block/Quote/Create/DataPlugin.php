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

namespace Cart2Quote\Quotation\Plugin\Magento\Quote\Block\Quote\Create;

/**
 * Class DataPlugin
 * @package Cart2Quote\Quotation\Plugin\Magento\Quote\Block\Quote\Create
 */
class DataPlugin
{
    /**
     * @var \Cart2Quote\Quotation\Model\ResourceModel\Quote $quoteResourceModel
     */
    protected $quoteResourceModel;

    /**
     * DataPlugin constructor.
     * @param \Cart2Quote\Quotation\Model\ResourceModel\Quote $quoteResourceModel
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\ResourceModel\Quote $quoteResourceModel
    ) {
        $this->quoteResourceModel = $quoteResourceModel;
    }

    /**
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Data $data
     * @param $label
     * @param $onclick
     * @param string $class
     * @param null $buttonId
     * @param array $dataAttr
     * @return array
     */
    public function beforeGetButtonHtml(
        \Magento\Sales\Block\Adminhtml\Order\Create\Data $data,
        $label,
        $onclick,
        $class = '',
        $buttonId = null,
        $dataAttr = []
    ) {
        $quotationQuote = $data->getQuote();
        if ($id = $quotationQuote->getId()) {
            $this->quoteResourceModel->load($quotationQuote, $id);
            if ($quotationQuote->getIncrementId()) {
                $label = 'Update Quote';
            }
        }

        return [__($label), $onclick, $class, $buttonId, $dataAttr];
    }
}
