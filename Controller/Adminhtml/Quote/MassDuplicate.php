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
 *
 */

namespace Cart2Quote\Quotation\Controller\Adminhtml\Quote;

/**
 * Class MassDuplicate
 *
 * @package Cart2Quote\Quotation\Controller\Adminhtml\Quote
 */
class MassDuplicate extends \Cart2Quote\Quotation\Controller\Adminhtml\Quote
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\Controller\Result\Redirect|null
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $selectedQuoteIds = $this->getRequest()->getPost('ids');
        $countSuccess = 0;
        $countFailed = 0;

        if (!is_array($selectedQuoteIds)) {
            $this->messageManager->addError(__('Please select items.'));
        } else {
            /**
             * @var \Cart2Quote\Quotation\Model\Quote $quote
             */
            foreach ($selectedQuoteIds as $id) {
                $originalQuote = $this->quoteFactory->create()->load($id);
                if (!$originalQuote->getId()) {
                    throw new \Magento\Framework\Exception\NoSuchEntityException(__('Quote %1 does not exist', $id));
                }
                $this->cloningHelper->cloneQuote($originalQuote);
            }
        }

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }
}
