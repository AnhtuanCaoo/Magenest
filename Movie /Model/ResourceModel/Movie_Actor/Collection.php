<?php
 
namespace Magenest\Movie\Model\ResourceModel\Movie_Actor;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = ['movie_id','actor_id'];
 
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Movie_Actor', 'Magenest\Movie\Model\ResourceModel\Movie_Actor');
    }
}