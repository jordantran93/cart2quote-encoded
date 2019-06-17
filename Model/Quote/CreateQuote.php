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

/**
 * Class CreateQuote
 * @package Cart2Quote\Quotation\Model\Quote
 */
class CreateQuote extends \Magento\Checkout\Model\Type\Onepage
{
    use \Cart2Quote\Features\Traits\Model\Quote\CreateQuote {
		saveNewCustomer as private traitSaveNewCustomer;
		saveExistingCustomer as private traitSaveExistingCustomer;
		saveCustomer as private traitSaveCustomer;
		saveAsGuest as private traitSaveAsGuest;
	}

	/**
     * Registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * CreateQuote constructor.
     * Overwrite the checkout session with the quote session.
     *
     * @param \Cart2Quote\Quotation\Model\Session $quoteSession
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Checkout\Helper\Data $helper
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Customer\Model\AddressFactory $customrAddrFactory
     * @param \Magento\Customer\Model\FormFactory $customerFormFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Framework\DataObject\Copy $objectCopyService
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Customer\Model\Metadata\FormFactory $formFactory
     * @param \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerDataFactory
     * @param \Magento\Framework\Math\Random $mathRandom
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Customer\Api\AddressRepositoryInterface $addressRepository
     * @param \Cart2Quote\Quotation\Api\AccountManagementInterface $accountManagement
     * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param \Magento\Quote\Api\CartManagementInterface $quoteManagement
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @param \Magento\Quote\Model\Quote\TotalsCollector $totalsCollector
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Cart2Quote\Quotation\Model\Session $quoteSession,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Checkout\Helper\Data $helper,
        \Magento\Customer\Model\Url $customerUrl,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Customer\Model\AddressFactory $customrAddrFactory,
        \Magento\Customer\Model\FormFactory $customerFormFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\DataObject\Copy $objectCopyService,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Customer\Model\Metadata\FormFactory $formFactory,
        \Magento\Customer\Api\Data\CustomerInterfaceFactory $customerDataFactory,
        \Magento\Framework\Math\Random $mathRandom,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Cart2Quote\Quotation\Api\AccountManagementInterface $accountManagement,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $orderSender,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Quote\Api\CartManagementInterface $quoteManagement,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Quote\Model\Quote\TotalsCollector $totalsCollector,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct(
            $eventManager,
            $helper,
            $customerUrl,
            $logger,
            $quoteSession,
            $customerSession,
            $storeManager,
            $request,
            $customrAddrFactory,
            $customerFormFactory,
            $customerFactory,
            $orderFactory,
            $objectCopyService,
            $messageManager,
            $formFactory,
            $customerDataFactory,
            $mathRandom,
            $encryptor,
            $addressRepository,
            $accountManagement,
            $orderSender,
            $customerRepository,
            $quoteRepository,
            $extensibleDataObjectConverter,
            $quoteManagement,
            $dataObjectHelper,
            $totalsCollector
        );

        $this->registry = $registry;
    }

    /**
     * Save the customer information for new customer
     *
     * @return void
     */
    public function saveNewCustomer()
    {
        $this->traitSaveNewCustomer();
    }

    /**
     * Save the customer information for existing customer with known email
     *
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return $this
     */
    public function saveExistingCustomer($customer)
    {
        return $this->traitSaveExistingCustomer($customer);
    }
    /**
     * Save the customer information for existing customer
     *
     * @return void
     */
    public function saveCustomer()
    {
        $this->traitSaveCustomer();
    }

    /**
     * Save as Guest
     *
     * @return void
     */
    public function saveAsGuest()
    {
        $this->traitSaveAsGuest();
    }
}
