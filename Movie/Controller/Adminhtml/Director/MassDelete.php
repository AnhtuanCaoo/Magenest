<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

class MassDelete extends \Magento\Backend\App\Action
{

    protected $_filter;


    protected $_collectionFactory;


    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magenest\Movie\Model\ResourceModel\Director\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }



    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());

        $delete = 0;
        foreach ($collection as $item) {
            $item->delete();
            $delete++;
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $delete));
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('movie/director/index');
    }
}
