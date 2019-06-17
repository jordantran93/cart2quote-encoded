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

namespace Cart2Quote\Quotation\Observer\Quote;

/**
 * Class Item
 * @package Cart2Quote\Quotation\Observer\Quote
 */
class Item implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Cart2Quote\Quotation\Model\Session
     */
    private $session;

    /**
     * Item constructor.
     * @param \Cart2Quote\Quotation\Model\Session $session
     */
    public function __construct(\Cart2Quote\Quotation\Model\Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $item = $observer->getItem();
        $quoteProductData = $this->session->getData(\Cart2Quote\Quotation\Model\Session::QUOTATION_PRODUCT_DATA);
        if (is_array($quoteProductData)) {
            foreach ($quoteProductData as $fieldName => &$productData) {
                foreach ($productData as $id => $value) {
                    if ($id == $item->getId()) {
                        $productData[$id] = $item->getData($fieldName);
                    }
                }
            }
            $this->session->addProductData($quoteProductData);
        }
    }
}
