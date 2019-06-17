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

namespace Cart2Quote\Quotation\Model\Quote\Email;

use Cart2Quote\Quotation\Model\Quote\Email\Sender\QuoteSenderInterface;

/**
 * Class Sender
 * @package Cart2Quote\Quotation\Model\Quote\Email
 */
abstract class AbstractSender implements QuoteSenderInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Email\AbstractSender {
		checkAndSend as private traitCheckAndSend;
		prepareTemplate as private traitPrepareTemplate;
		getTemplateOptions as private traitGetTemplateOptions;
		getSender as private traitGetSender;
		getFormattedShippingAddress as private traitGetFormattedShippingAddress;
		getFormattedBillingAddress as private traitGetFormattedBillingAddress;
	}

	/**
     * @var \Cart2Quote\Quotation\Model\Quote\Pdf\Quote
     */
    protected $_pdfModel;

    /**
     * @var \Magento\Sales\Model\Order\Email\SenderBuilderFactory
     */
    protected $senderBuilderFactory;

    /**
     * @var \Magento\Sales\Model\Order\Email\Container\Template
     */
    protected $templateContainer;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface
     */
    protected $identityContainer;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote\Address\Renderer
     */
    protected $addressRenderer;

    /**
     * Sender constructor.
     * @param \Magento\Sales\Model\Order\Email\Container\Template $templateContainer
     * @param \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface $identityContainer
     * @param \Cart2Quote\Quotation\Model\Quote\Email\SenderBuilderFactory $senderBuilderFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Cart2Quote\Quotation\Model\Quote\Address\Renderer $addressRenderer
     * @param \Cart2Quote\Quotation\Model\Quote\Pdf\Quote $pdfModel
     */
    public function __construct(
        \Magento\Sales\Model\Order\Email\Container\Template $templateContainer,
        \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface $identityContainer,
        \Cart2Quote\Quotation\Model\Quote\Email\SenderBuilderFactory $senderBuilderFactory,
        \Psr\Log\LoggerInterface $logger,
        \Cart2Quote\Quotation\Model\Quote\Address\Renderer $addressRenderer,
        \Cart2Quote\Quotation\Model\Quote\Pdf\Quote $pdfModel
    ) {
        $this->templateContainer = $templateContainer;
        $this->identityContainer = $identityContainer;
        $this->senderBuilderFactory = $senderBuilderFactory;
        $this->logger = $logger;
        $this->addressRenderer = $addressRenderer;
        $this->_pdfModel = $pdfModel;
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @param array|null $attachments
     * @return bool
     */
    protected function checkAndSend(
        \Cart2Quote\Quotation\Model\Quote $quote,
        $attachments = null
    ) {
        return $this->traitCheckAndSend($quote, $attachments);
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     */
    protected function prepareTemplate(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        $this->traitPrepareTemplate($quote);
    }

    /**
     * @return array
     */
    protected function getTemplateOptions()
    {
        return $this->traitGetTemplateOptions();
    }

    /**
     * @return AbstractSender
     */
    protected function getSender()
    {
        return $this->traitGetSender();
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return null|string
     */
    protected function getFormattedShippingAddress(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        return $this->traitGetFormattedShippingAddress($quote);
    }

    /**
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return null|string
     */
    protected function getFormattedBillingAddress($quote)
    {
        return $this->traitGetFormattedBillingAddress($quote);
    }
}
