<?php
 
namespace Magenest\Movie\Model\ResourceModel;
 
class Movie_Actor extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('magenest_movie_actor', ['movie_id', 'actor_id']);
    }
    
}