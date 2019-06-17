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

namespace Cart2Quote\Quotation\Controller\MoveToQuote;

/**
 * Class Index
 * @package Cart2Quote\Quotation\Controller\MoveToQuote
 */
class Index extends \Cart2Quote\Quotation\Controller\MoveToQuote
{
    /**
     * Shopping cart display action
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $copiedQuote = $this->cloneQuote();
            $this->messageManager->addSuccessMessage(__('The cart is successfully moved to the quote.'));
            $this->checkoutSession->clearQuote();
            $this->checkoutSession->clearStorage();
            $this->quotationSession->setQuoteId($copiedQuote->getId());
            $resultRedirect->setPath('quotation/quote/index');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        }

        return $resultRedirect;
    }
}
