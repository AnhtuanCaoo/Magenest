<?php

namespace Magenest\NotificationBox\Ui\Component\NotificationType;

use Magento\Framework\Data\OptionSourceInterface;
use Magenest\NotificationBox\Model\NotificationType;

/**
 * Class BooleanFilter
 * Magenest\NotificationBox\Ui\Component\NotificationType
 */
class BooleanFilter implements OptionSourceInterface
{
    const FILTERABLE=1;
    const NOT_FILTERABLE=0;
    /**
     * Get option array
     */
    protected function getOptionArray()
    {
        return [
            NotificationType::IS_CATEGORY => __('Yes'),
            NotificationType::IS_NOT_CATEGORY => __('No')
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
