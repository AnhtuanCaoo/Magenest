<?php
 
namespace Magenest\Movie\Model\ResourceModel\Actor;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'actor_id';
 
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\Actor', 'Magenest\Movie\Model\ResourceModel\Actor');
    }
    public function countRowInTable(){
        $result = $this->getConnection();
        $collect = $result->Select()->from($this->getMainTable(),['countrow' => 'COUNT(*)'] );
        return (int)$result->fetchOne($collect);
    }
}