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

namespace Cart2Quote\Quotation\Model\Quote\Status;

/**
 * Quote status history comments
 * @method \Cart2Quote\Quotation\Model\ResourceModel\Quote\Status\History _getResource()
 * @method \Cart2Quote\Quotation\Model\ResourceModel\Quote\Status\History getResource()
 */
class History extends \Magento\Sales\Model\AbstractModel implements \Cart2Quote\Quotation\Api\Data\QuoteStatusHistoryInterface
{
    use \Cart2Quote\Features\Traits\Model\Quote\Status\History {
		setIsCustomerNotified as private traitSetIsCustomerNotified;
		isCustomerNotificationNotApplicable as private traitIsCustomerNotificationNotApplicable;
		getIsCustomerNotified as private traitGetIsCustomerNotified;
		getStatusLabel as private traitGetStatusLabel;
		getQuote as private traitGetQuote;
		setQuote as private traitSetQuote;
		getStatus as private traitGetStatus;
		getStore as private traitGetStore;
		beforeSave as private traitBeforeSave;
		getParentId as private traitGetParentId;
		setParentId as private traitSetParentId;
		getComment as private traitGetComment;
		getCreatedAt as private traitGetCreatedAt;
		setCreatedAt as private traitSetCreatedAt;
		getEntityId as private traitGetEntityId;
		getEntityName as private traitGetEntityName;
		getIsVisibleOnFront as private traitGetIsVisibleOnFront;
		setIsVisibleOnFront as private traitSetIsVisibleOnFront;
		setComment as private traitSetComment;
		setStatus as private traitSetStatus;
		setEntityName as private traitSetEntityName;
		getExtensionAttributes as private traitGetExtensionAttributes;
		setExtensionAttributes as private traitSetExtensionAttributes;
		_construct as private _traitConstruct;
	}

	const CUSTOMER_NOTIFICATION_NOT_APPLICABLE = 2;

    /**
     * Quote instance
     * @var \Cart2Quote\Quotation\Model\Quote
     */
    protected $_quote;

    /**
     * @var string
     */
    protected $_eventPrefix = 'quotation_quote_status_history';

    /**
     * @var string
     */
    protected $_eventObject = 'status_history';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $resource,
            $resourceCollection,
            $data
        );
        $this->_storeManager = $storeManager;
    }

    /**
     * Notification flag
     * @param  mixed $flag OPTIONAL (notification is not applicable by default)
     * @return $this
     */
    public function setIsCustomerNotified($flag = null)
    {
        return $this->traitSetIsCustomerNotified($flag);
    }

    /**
     * Customer Notification Applicable check method
     * @return boolean
     */
    public function isCustomerNotificationNotApplicable()
    {
        return $this->traitIsCustomerNotificationNotApplicable();
    }

    /**
     * Returns is_customer_notified
     * @return int
     */
    public function getIsCustomerNotified()
    {
        return $this->traitGetIsCustomerNotified();
    }

    /**
     * Retrieve status label
     * @return string|null
     */
    public function getStatusLabel()
    {
        return $this->traitGetStatusLabel();
    }

    /**
     * Retrieve quote instance
     * @return \Cart2Quote\Quotation\Model\Quote
     */
    public function getQuote()
    {
        return $this->traitGetQuote();
    }

    /**
     * Set quote object and grab some metadata from it
     * @param \Cart2Quote\Quotation\Model\Quote $quote
     * @return $this
     */
    public function setQuote(\Cart2Quote\Quotation\Model\Quote $quote)
    {
        return $this->traitSetQuote($quote);
    }

    /**
     * Returns status
     * @return string
     */
    public function getStatus()
    {
        return $this->traitGetStatus();
    }

    /**
     * Get store object
     * @return \Magento\Store\Model\Store
     */
    public function getStore()
    {
        return $this->traitGetStore();
    }

    /**
     * Set quote again if required
     * @return $this
     */
    public function beforeSave()
    {
        return $this->traitBeforeSave();
    }

    /**
     * Returns parent_id
     * @return int
     */
    public function getParentId()
    {
        return $this->traitGetParentId();
    }

    /**
     * {@inheritdoc}
     */
    public function setParentId($id)
    {
        return $this->traitSetParentId($id);
    }

    /**
     * Returns comment
     * @return string
     */
    public function getComment()
    {
        return $this->traitGetComment();
    }

    /**
     * Returns created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->traitGetCreatedAt();
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt($createdAt)
    {
        return $this->traitSetCreatedAt($createdAt);
    }

    /**
     * Returns entity_id
     * @return int
     */
    public function getEntityId()
    {
        return $this->traitGetEntityId();
    }

    /**
     * Returns entity_name
     * @return string
     */
    public function getEntityName()
    {
        return $this->traitGetEntityName();
    }

    /**
     * Returns is_visible_on_front
     * @return int
     */
    public function getIsVisibleOnFront()
    {
        return $this->traitGetIsVisibleOnFront();
    }

    /**
     * {@inheritdoc}
     */
    public function setIsVisibleOnFront($isVisibleOnFront)
    {
        return $this->traitSetIsVisibleOnFront($isVisibleOnFront);
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        return $this->traitSetComment($comment);
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        return $this->traitSetStatus($status);
    }

    /**
     * {@inheritdoc}
     */
    public function setEntityName($entityName)
    {
        return $this->traitSetEntityName($entityName);
    }

    /**
     * {@inheritdoc}
     * @return \Magento\Sales\Api\Data\OrderStatusHistoryExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->traitGetExtensionAttributes();
    }

    /**
     * {@inheritdoc}
     * @param \Magento\Sales\Api\Data\OrderStatusHistoryExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Magento\Sales\Api\Data\OrderStatusHistoryExtensionInterface $extensionAttributes
    ) {
        return $this->traitSetExtensionAttributes($extensionAttributes);
    }

    /**
     * Initialize resourcemodel
     * @return void
     */
    protected function _construct()
    {
        $this->_traitConstruct();
    }
}
