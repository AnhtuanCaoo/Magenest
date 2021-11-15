<?php

namespace Magenest\NotificationBox\Block\Adminhtml\Report;

use Magenest\NotificationBox\Model\CustomerToken;
use Magenest\NotificationBox\Model\ResourceModel\CustomerToken\CollectionFactory;
use Magento\Backend\Block\Template;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface as DateTime;

class Report extends Template
{

    /** @var DateTime  */
    protected $dateTime;

    /** @var CollectionFactory  */
    protected $collectionFactory;

    /**
     * Construct
     *
     * @param CollectionFactory $collectionFactory
     * @param Template\Context $context
     * @param DateTime $dateTime
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        Template\Context $context,
        DateTime $dateTime,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->dateTime = $dateTime;
        parent::__construct($context, $data);
    }
    /**
     * Get total subcribers
     */
    public function getTotalSubscribers()
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter('status', CustomerToken::STATUS_SUBSCRIBED)->count();
    }
    /**
     * Get total unSubscribers
     */
    public function getTotalUnSubscribers()
    {
        return $this->collectionFactory->create()
            ->addFieldToFilter('status', CustomerToken::STATUS_UNSUBSCRIBED)->count();
    }
    /**
     * Get time now
     */
    public function getTimeNow()
    {
        return $this->dateTime->date()->format('Y-m-d');
    }
    /**
     * Get time before 7 day
     */
    public function getTimeBefore7Day()
    {
        return date('Y-m-d', strtotime('-' . 7 . 'day', strtotime($this->getTimeNow())));
    }
}
