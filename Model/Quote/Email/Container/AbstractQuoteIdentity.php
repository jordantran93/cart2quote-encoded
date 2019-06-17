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

namespace Cart2Quote\Quotation\Model\Quote\Email\Container;

/**
 * Class AbstractQuoteIdentity
 *
 * @package Cart2Quote\Quotation\Model\Quote\Email\Container
 */
abstract class AbstractQuoteIdentity extends Container implements IdentityInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Email\Container\AbstractQuoteIdentity {
		isEnabled as private traitIsEnabled;
		getEmailCopyTo as private traitGetEmailCopyTo;
		getCopyMethod as private traitGetCopyMethod;
		getTemplateId as private traitGetTemplateId;
		isSendCopyToSalesRep as private traitIsSendCopyToSalesRep;
		getEmailIdentity as private traitGetEmailIdentity;
		getGuestTemplateId as private traitGetGuestTemplateId;
		getRecieverEmail as private traitGetRecieverEmail;
		getRecieverName as private traitGetRecieverName;
	}

	/**
     * Configuration paths
     */
    const XML_PATH_EMAIL_COPY_METHOD = '';
    const XML_PATH_EMAIL_COPY_TO = '';
    const XML_PATH_EMAIL_IDENTITY = '';
    const XML_PATH_EMAIL_TEMPLATE = '';
    const XML_PATH_EMAIL_ENABLED = '';
    const XML_PATH_EMAIL_GUEST_TEMPLATE = '';
    /**
     * @var bool
     */
    protected $sendCopyToSalesRep;

    /**
     * AbstractQuoteIdentity constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param bool $sendCopyToSalesRep
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        $sendCopyToSalesRep = false
    ) {
        parent::__construct($scopeConfig, $storeManager);
        $this->sendCopyToSalesRep = $sendCopyToSalesRep;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->traitIsEnabled();
    }

    /**
     * Return email copy_to list
     *
     * @return array|bool
     */
    public function getEmailCopyTo()
    {
        return $this->traitGetEmailCopyTo();
    }

    /**
     * Return copy method
     *
     * @return mixed
     */
    public function getCopyMethod()
    {
        return $this->traitGetCopyMethod();
    }

    /**
     * Return template id
     *
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->traitGetTemplateId();
    }

    /**
     * @return bool
     */
    public function isSendCopyToSalesRep()
    {
        return $this->traitIsSendCopyToSalesRep();
    }

    /**
     * Return email identity
     *
     * @return mixed
     */
    public function getEmailIdentity()
    {
        return $this->traitGetEmailIdentity();
    }

    /**
     * Return template id
     *
     * @return mixed
     */
    public function getGuestTemplateId()
    {
        return $this->traitGetGuestTemplateId();
    }

    /**
     * @return string
     */
    public function getRecieverEmail()
    {
        return $this->traitGetRecieverEmail();
    }

    /**
     * @return string
     */
    public function getRecieverName()
    {
        return $this->traitGetRecieverName();
    }
}
