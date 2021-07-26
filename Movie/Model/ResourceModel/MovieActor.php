<?php
 
namespace Magenest\Movie\Model\ResourceModel;
 
class MovieActor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_movie_actor', 'id_table');
    }
    
}