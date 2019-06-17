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

namespace Cart2Quote\Quotation\Helper;

/**
 * Class Address
 * @package Cart2Quote\Quotation\Helper
 */
class Address extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @const Shipping address grid config
     */
    const SHIPPING_ADDRESS_GRID = 'cart2quote_quote_form_settings/quote_form_settings_configuration/shipping_address_grid';

    /**
     * @const Billing address grid config
     */
    const BILLING_ADDRESS_GRID = 'cart2quote_quote_form_settings/quote_form_settings_configuration/billing_address_grid';

    /**
     * @const Address type
     */
    const ALLOW_GUEST = 'cart2quote_quote_form_settings/quote_form_settings/allow_guest_quote_request';

    /**
     * @const Allow to show form
     */
    const ENABLE_FORM = 'cart2quote_quote_form_settings/quote_form_settings/enable_form';

    /**
     * @const System path to allow guest quote request with existing email
     */
    const ENABLE_GUEST_EXISTING = 'cart2quote_quote_form_settings/quote_form_settings/allow_guest_quote_request_existing';

    /**
     * Address field attributes:
     */
    const ADDRESS_FIELD_LABEL = 'label';
    const ADDRESS_FIELD_NAME = 'name';
    const ADDRESS_FIELD_REQUIRED = 'required';
    const ADDRESS_FIELD_ADDITIONAL_CSS = 'additionalCss';
    const ADDRESS_FIELD_ENABLED = 'enabled';
    const ADDRESS_FIELD_LOCKED = 'locked';
    const ADDRESS_FIELD_SORT_ORDER = 'sortOrder';

    /**
     * Path to enable shipping methods
     */
    const XML_PATH_DISPLAY_SHIPPING_METHODS = 'cart2quote_quote_form_settings/quote_form_settings/display_shipping_methods';

    /**
     * Path to enable auto log in
     */
    const ENABLE_AUTO_LOGIN = 'cart2quote_quote_form_settings/quote_form_settings/auto_login';

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $configWriter;

    /**
     * Address constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
    ) {
        $this->configWriter = $configWriter;
        parent::__construct($context);
    }

    /**
     * Get shipping address grid settings
     *
     * @return array
     */
    public function getShippingAddressConfig()
    {
        return json_decode($this->scopeConfig->getValue(
            self::SHIPPING_ADDRESS_GRID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ));
    }

    /**
     * Get shipping address grid settings as array
     *
     * @return array
     */
    public function getShippingAddressConfigArray()
    {
        return json_decode($this->scopeConfig->getValue(
            self::SHIPPING_ADDRESS_GRID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ), true);
    }

    /**
     * @return array
     */
    public function getAddressConfigArrays()
    {
        return [
            "billing" => $this->getBillingAddressConfigArray(),
            "shipping" => $this->getShippingAddressConfigArray()
        ];
    }

    /**
     * Save new address config to core_config_data table
     *
     * @param array $configs
     */
    public function setAddressConfig($configs)
    {
        $keys = ['shipping' => self::SHIPPING_ADDRESS_GRID, 'billing' => self::BILLING_ADDRESS_GRID];
        foreach ($keys as $key => $configPath) {
            if (isset($configs[$key]) && is_array($configs[$key])) {
                $this->configWriter->save(
                    $configPath,
                    json_encode($configs[$key])
                );
            }
        }
    }

    /**
     * Get billing address grid settings
     *
     * @return array
     */
    public function getBillingAddressConfig()
    {
        return json_decode($this->scopeConfig->getValue(
            self::BILLING_ADDRESS_GRID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ));
    }

    /**
     * Get billing address grid settings as array
     *
     * @return array
     */
    public function getBillingAddressConfigArray()
    {
        return json_decode($this->scopeConfig->getValue(
            self::BILLING_ADDRESS_GRID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ), true);
    }

    /**
     * Get address type setting
     *
     * @return array
     */
    public function getAllowGuestConfig()
    {
        return $this->getEnableForm() && json_decode($this->scopeConfig->getValue(
            self::ALLOW_GUEST,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ));
    }

    /**
     * Get allow existing customer guest quote request
     *
     * @return integer
     */
    public function getRegisteredQuoteCheckoutConfig()
    {
        return $this->scopeConfig->getValue(
            self::ENABLE_GUEST_EXISTING,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get allow existing customer guest quote request
     *
     * @return boolean
     */
    public function getAutoLogIn()
    {
        return (bool)$this->scopeConfig->getValue(
            self::ENABLE_AUTO_LOGIN,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get display shipping methods setting
     *
     * @return boolean
     */
    public function getDisplayShipping()
    {
        return (boolean)$this->scopeConfig->getValue(
            self::XML_PATH_DISPLAY_SHIPPING_METHODS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get allow to use form
     *
     * @return bool
     */
    public function getEnableForm()
    {
        return (bool)$this->scopeConfig->getValue(self::ENABLE_FORM);
    }

    /**
     * This is the default address configuration.
     * Used in the backend configuration for the shipping and billing address.
     * Also used when a customer is logged in.
     *
     * @return array[\stdClass]
     */
    public function getDefaultAddressConfig()
    {
        return [
            (object)[
                self::ADDRESS_FIELD_LABEL => 'First Name',
                self::ADDRESS_FIELD_NAME => 'firstname',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => true,
                self::ADDRESS_FIELD_SORT_ORDER => 10
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Last Name',
                self::ADDRESS_FIELD_NAME => 'lastname',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => true,
                self::ADDRESS_FIELD_SORT_ORDER => 20
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Company',
                self::ADDRESS_FIELD_NAME => 'company',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 30
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Street Address',
                self::ADDRESS_FIELD_NAME => 'street',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 40
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'City',
                self::ADDRESS_FIELD_NAME => 'city',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 50
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'State/Province',
                self::ADDRESS_FIELD_NAME => 'region_id',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 60
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Zip/Postal Code',
                self::ADDRESS_FIELD_NAME => 'postcode',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 70
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Country',
                self::ADDRESS_FIELD_NAME => 'country_id',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 80
            ],
            (object)[
                self::ADDRESS_FIELD_LABEL => 'Phone Number',
                self::ADDRESS_FIELD_NAME => 'telephone',
                self::ADDRESS_FIELD_REQUIRED => true,
                self::ADDRESS_FIELD_ADDITIONAL_CSS => '',
                self::ADDRESS_FIELD_ENABLED => true,
                self::ADDRESS_FIELD_LOCKED => false,
                self::ADDRESS_FIELD_SORT_ORDER => 90
            ]
        ];
    }
}
