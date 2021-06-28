<?php
 
namespace Magenest\Movie\Model\ResourceModel\MovieActor;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id_table';
 
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\MovieActor', 'Magenest\Movie\Model\ResourceModel\MovieActor');
    }
}