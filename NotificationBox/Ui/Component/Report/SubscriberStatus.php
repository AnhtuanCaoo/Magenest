<?php

namespace Magenest\NotificationBox\Ui\Component\Report;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\NotificationBox\Model\CustomerToken;

/**
 * Class BooleanFilter
 */
class SubscriberStatus implements OptionSourceInterface
{
    /**
     * Get option array
     */
    protected function getOptionArray()
    {
        return [
            CustomerToken::STATUS_SUBSCRIBED => __('Subscribed'),
            CustomerToken::STATUS_UNSUBSCRIBED => __('Unsubscribed')
        ];
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $res = [];
        foreach (self::getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }
}
