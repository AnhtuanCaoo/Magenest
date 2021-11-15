<?php
namespace Magenest\CouponCode\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magenest\CouponCode\Model\ResourceModel\ClaimCoupon\CollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\Http\Context;

class MyCoupon extends Template implements IdentityInterface
{
    const CACHE_TAG = 'MAGENEST_MY_COUPON_LISTING';
    /**
     * @var Context
     */
    private $httpContext;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var ResourceConnection
     */
    private $resource;

    /**
     * Data constructor
     *
     * @param Template\Context $context
     * @param Context $httpContext
     * @param CollectionFactory $collectionFactory
     * @param ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Context $httpContext,
        CollectionFactory $collectionFactory,
        ResourceConnection $resource,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->httpContext = $httpContext;
        $this->collectionFactory = $collectionFactory;
        $this->resource = $resource;
    }
    /**
     * Prepare for paging
     *
     * @return MyCoupon
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $page_data = $this->getCoupon();
        if ($this->getCoupon()) {
            $pager = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'custom.mycoupon.page'
            )
                ->setAvailableLimit(Coupon::DEFAULT_ITEM)
                ->setShowPerPage(true)
                ->setCollection($page_data);
            $this->setChild('pager', $pager);
            $this->getCoupon()->load();
        }
        return $this;
    }

    /**
     * Get pager
     *
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
    /**
     * Get all coupon claimed
     *
     * @return \Magenest\CouponCode\Model\ResourceModel\ClaimCoupon\Collection
     */
    public function getCoupon()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit')) ? $this->getRequest(
        )->getParam('limit') : 12;
        $salesRule = $this->resource->getTableName('salesrule');
        return $this->collectionFactory->create()
            ->addFieldToFilter('is_active', 1)
            ->addFieldtoFilter('customer_id', $this->httpContext->getValue('customer_id'))
            ->setOrder('claimed_at', 'DESC')
            ->setOrder($salesRule.'.to_date', 'ASC')
            ->setPageSize($pageSize)
            ->setCurPage($page);
    }

    /**
     * Get Tag
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG];
        // TODO: Implement getIdentities() method.
    }
}
