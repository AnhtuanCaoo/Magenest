<?php
namespace Magenest\Movie\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveObserver implements ObserverInterface
{
    protected $_movieFactory;
    public function __construct(
        \Magenest\Movie\Model\MovieFactory $movieFactory
    )
    {
        $this->_movieFactory = $movieFactory;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            // Get the model object from observer
            $object = $observer->getData('save_event');
            $object->setData('rating',1);
            $observer->setData('save_event',$object);

        } catch (\Exception $e) {
            var_dump('fail');
        }
    }
}
