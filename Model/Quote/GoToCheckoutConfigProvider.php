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

namespace Cart2Quote\Quotation\Model\Quote;

use Magento\Checkout\Model\Session as CheckoutSession;

/**
 * Class GoToCheckoutConfigProvider
 * @package Cart2Quote\Quotation\Model\Quote
 */
class GoToCheckoutConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\GoToCheckoutConfigProvider {
		getConfig as private traitGetConfig;
		getCustomerData as private traitGetCustomerData;
	}

	/**
     * Checkout session
     *
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * GoToCheckoutConfigProvider constructor.
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CheckoutSession $checkoutSession
    ) {
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Get the config for the checkout provider
     * The below function adds the following to the config provider:
     * - quotationCustomerData - this is for the guest checkout: the first name, last name and email
     * - quotationGuestCheckout - flag for guest
     * - isGuestCheckoutAllowed - Magento flag for guest
     * @return array
     */
    public function getConfig()
    {
        return $this->traitGetConfig();
    }

    /**
     * Retrieve customer data
     *
     * @return array
     */
    private function getCustomerData()
    {
        return $this->traitGetCustomerData();
    }
}
