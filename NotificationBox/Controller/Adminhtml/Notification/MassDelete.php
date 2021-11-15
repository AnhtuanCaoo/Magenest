<?php
namespace Magenest\NotificationBox\Controller\Adminhtml\Notification;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class MassDelete extends AbstractMassAction
{
    /**
     * Delete notification
     *
     * @param AbstractCollection $collection
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Exception
     */
    protected function massAction(AbstractCollection $collection)
    {
        $count = 0;
        foreach ($collection->getItems() as $item) {
            $this->notificationResource->delete($item);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('Total of %1 record(s) have been deleted.', $count));
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath($this->redirectUrl);
        return $resultRedirect;
    }
}
