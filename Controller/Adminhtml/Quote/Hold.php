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

namespace Cart2Quote\Quotation\Controller\Adminhtml\Quote;

/**
 * Class Hold
 * @package Cart2Quote\Quotation\Controller\Adminhtml\Quote
 */
class Hold extends \Cart2Quote\Quotation\Controller\Adminhtml\Quote
{
    /**
     * View quote detail
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $quote = $this->_initQuote();

        if ($quote) {
            if ($quote->canHold()) {
                $quote->setState(\Cart2Quote\Quotation\Model\Quote\Status::STATE_HOLDED)
                    ->setStatus(\Cart2Quote\Quotation\Model\Quote\Status::STATUS_HOLDED)->save();
            }
        }

        return $this->resultRedirectFactory->create()->setPath('quotation/quote/view', ['quote_id' => $quote->getId()]);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Cart2Quote_Quotation::hold');
    }
}
