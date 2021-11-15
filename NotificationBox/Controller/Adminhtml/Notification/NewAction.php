<?php

namespace Magenest\NotificationBox\Controller\Adminhtml\Notification;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class NewAction extends \Magento\Backend\App\Action
{
    /** @var PageFactory  */
    protected $resultPageFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Create page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Notification Information'));
        return $resultPage;
    }
    /**
     * ACL
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_NotificationBox::notification');
    }
}
