<?php
namespace Magenest\Customer\Plugin;

use Magento\Framework\Serialize\Serializer\Json;

class Images
{
    protected $serialize;
    public function __construct(
        Json $serialize
    )
    {
        $this->serialize = $serialize;
    }

    public function afterGetData(\Magento\SalesRule\Model\Rule\DataProvider $subject, $result){
        foreach($result as $value) {
            $id = $value['rule_id'];
        }
        if (!empty($result[$id]['images'])) {
            $result[$id]['images'] = $this->serialize->unserialize($value['images']);

        }
        return $result;
    }
}
