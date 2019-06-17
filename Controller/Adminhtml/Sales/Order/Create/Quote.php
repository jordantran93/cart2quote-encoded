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

namespace Cart2Quote\Quotation\Controller\Adminhtml\Sales\Order\Create;

/**
 * Class Quote
 * @package Cart2Quote\Quotation\Controller\Adminhtml\Sales\Order\Create
 */
class Quote extends \Cart2Quote\Quotation\Controller\Adminhtml\Quote\Edit
{
    /**
     * @return \Magento\Backend\Model\View\Result\Forward|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $quote = $this->_getSession()->getQuote();
            $quoteId = $this->_getSession()->getQuoteId();
            $quotation = $this->quoteFactory->create()->load($quoteId);
            if (!$quotation->getId()) {
                $quotation = $this->quoteFactory->create()->create($quote)->load($quoteId);
                $this->_getSession()->clearStorage();
            }
            if ($this->_authorization->isAllowed('Cart2Quote_Quotation::actions_view')) {
                $resultRedirect->setPath('quotation/quote/view', ['quote_id' => $quoteId]);
            } else {
                $resultRedirect->setRefererUrl();
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(sprintf(
                "%s: %s",
                __("Cannot convert Quote"),
                $e->getMessage()));
            $resultRedirect->setRefererUrl();
        }

        return $resultRedirect;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Cart2Quote_Quotation::actions');
    }
}