<?php
namespace Magenest\Movie\Controller\Index;
use Magento\Framework\App\Action\Action;
class Index extends Action
{
    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    protected $context;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    /**
     * Index action
     *
     * @return $this
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;

    }
}
