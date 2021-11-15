<?php
namespace Magenest\NotificationBox\Controller\Adminhtml\Register;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class MassDelete extends AbstractMassAction
{
    /**
     * Mass delete
     *
     * @param AbstractCollection $collection
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Exception
     */
    protected function massAction(AbstractCollection $collection)
    {
        $count = 0;
        foreach ($collection->getItems() as $item) {
            $this->customerTokenResource->delete($item);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been delete.', $count));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectUrl);
        return $resultRedirect;
    }
}
