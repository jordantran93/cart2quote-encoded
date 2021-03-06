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

namespace Cart2Quote\Quotation\Controller\AbstractController;

/**
 * Class QuoteViewAuthorization
 * @package Cart2Quote\Quotation\Controller\AbstractController
 */
class QuoteViewAuthorization implements QuoteViewAuthorizationInterface
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Sales\Model\Order\Config
     */
    protected $quoteConfig;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Cart2Quote\Quotation\Model\Quote\Config $quoteConfig
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Cart2Quote\Quotation\Model\Quote\Config $quoteConfig
    ) {
        $this->customerSession = $customerSession;
        $this->quoteConfig = $quoteConfig;
    }

    /**
     * Check if quote can be viewed by user
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return bool
     */
    public function canView(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        $customerId = $this->customerSession->getCustomerId();
        $availableStatuses = $this->quoteConfig->getVisibleOnFrontStatuses();
        if ($quote->getId()
            && $quote->getCustomerId()
            && $quote->getCustomerId() == $customerId
            && in_array($quote->getStatus(), $availableStatuses, true)
        ) {
            return true;
        }
        return false;
    }
}
