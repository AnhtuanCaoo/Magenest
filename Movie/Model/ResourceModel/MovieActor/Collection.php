<?php
 
namespace Magenest\Movie\Model\ResourceModel\MovieActor;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id_table';
 
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\MovieActor', 'Magenest\Movie\Model\ResourceModel\MovieActor');
    }
    public function joinTable(){
        $actorTable = $this->getTable('magenest_actor');
        $actormovieTable = $this->getTable('magenest_movie_actor');
        $directorTable = $this->getTable('magenest_director');
        $movieTable= $this->getTable('magenest_movie');
        $result = $this->getSelect()
        ->join($movieTable, 'main_table.movie_id='.$movieTable.'.movie_id')
        ->join($actorTable,'main_table.actor_id='.$actorTable.'.actor_id');
        // ->join($directorTable,$movieTable.'.movie_id='.$directorTable.'.director_id');
        // ->where('main_table.movie_id='.$actormovieTable.'.movie_id')
        // ->group('main_table.movie_id');
        return $result;
    }
}