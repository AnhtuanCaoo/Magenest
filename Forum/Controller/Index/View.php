<?php
namespace Magenest\Forum\Controller\Index;

use Braintree\Collection;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Action;
use Magenest\Forum\Model\ResourceModel\Post\CollectionFactory;
class View extends Action
{
    protected $blog;
    /** @var PageFactory  */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        CollectionFactory $blog,
        PageFactory $resultPageFactory
    ) {

        parent::__construct($context);
        $this->blog = $blog;
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $request = array_keys($this->getRequest()->getParams());
        if(!empty($request[0])){
            $id = $request[0];
            $data = $this->blog->create()->getItemById($id);
            if(!empty($data)){
                $title = $data->getData('title');
                $resultPage = $this->resultPageFactory->create();
                $resultPage->getConfig()->getTitle()->set($title);
                return $resultPage;
            }else{
                return $this->_redirect('forum/index/index');
            }
        }else{
            return $this->_redirect('forum/index/index');

        }

    }
}
