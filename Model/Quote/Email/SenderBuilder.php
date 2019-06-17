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
 *
 * @category    Cart2Quote
 * @package     Quotation
 * @copyright   Copyright (c) 2018. Cart2Quote B.V. (https://www.cart2quote.com)
 * @license     https://www.cart2quote.com/ordering-licenses(https://www.cart2quote.com)
 */

namespace Cart2Quote\Quotation\Model\Quote\Email;

/**
 * Class SenderBuilder
 *
 * @package Cart2Quote\Quotation\Model\Quote\Email
 */
class SenderBuilder extends \Magento\Sales\Model\Order\Email\SenderBuilder
{
    use \Cart2Quote\Features\Traits\Model\Quote\Email\SenderBuilder {
		send as private traitSend;
		sendCopyTo as private traitSendCopyTo;
	}

	/**
     * @var \Magento\Sales\Model\Order\Email\Container\Template
     */
    protected $templateContainer;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface
     */
    protected $identityContainer;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Cart2Quote\Quotation\Model\Quote\Email\UploadTransportBuilder
     */
    protected $uploadTransportBuilder;

    /**
     * Sender resolver
     *
     * @var \Magento\Framework\Mail\Template\SenderResolverInterface
     */
    protected $senderResolver;

    /**
     * SenderBuilder constructor.
     *
     * @param \Cart2Quote\Quotation\Model\Quote\Email\UploadTransportBuilder $uploadTransportBuilder
     * @param \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver
     * @param \Magento\Sales\Model\Order\Email\Container\Template $templateContainer
     * @param \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface $identityContainer
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     */
    public function __construct(
        UploadTransportBuilder $uploadTransportBuilder,
        \Magento\Framework\Mail\Template\SenderResolverInterface $senderResolver,
        \Magento\Sales\Model\Order\Email\Container\Template $templateContainer,
        \Cart2Quote\Quotation\Model\Quote\Email\Container\IdentityInterface $identityContainer,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
        if (class_exists('\Magento\Framework\Mail\Template\TransportBuilderByStore')) {
            parent::__construct(
                $templateContainer,
                $identityContainer,
                $transportBuilder,
                \Magento\Framework\App\ObjectManager::getInstance()->create(
                    \Magento\Framework\Mail\Template\TransportBuilderByStore::class
                )
            );
        } else {
            parent::__construct(
                $templateContainer,
                $identityContainer,
                $transportBuilder
            );
        }

        $this->templateContainer = $templateContainer;
        $this->identityContainer = $identityContainer;
        $this->transportBuilder = $transportBuilder;
        $this->uploadTransportBuilder = $uploadTransportBuilder;
        $this->senderResolver = $senderResolver;
    }

    /**
     * Prepare and send email message
     *
     * @param array|null $attachments
     */
    public function send(
        $attachments = null
    ) {
        $this->traitSend($attachments);
    }

    /**
     * Prepare and send copy email message
     *
     * @return void
     */
    public function sendCopyTo()
    {
        $this->traitSendCopyTo();
    }
}
