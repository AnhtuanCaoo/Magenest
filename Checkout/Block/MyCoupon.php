<?php
namespace Magenest\Checkout\Block;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Customer\Model\Session;
use Magenest\Checkout\Model\ResourceModel\ClaimCoupon\CollectionFactory;
use Magento\Authorization\Model\UserContextInterface;

class MyCoupon extends Template
{
    private $user;
    private $json;
    private $collectionFactory;
    public function __construct(
        Template\Context $context,
        UserContextInterface $user,
        CollectionFactory $collectionFactory,
        DateTime $date,
        Json $json,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->user = $user;
        $this->collectionFactory = $collectionFactory;
        $this->date = $date;
        $this->json = $json;
    }
    public function getCoupon() {
        $coupon = [];
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldtoFilter('customer_id', $this->user->getUserId());
        foreach($collection as $value) {
            $images = $value->getData('images');
            if(!empty($images)){
                $value->setData('images', $this->json->unserialize($images));
            }
                array_push($coupon, $value);
        }
        return $coupon;
    }

}
