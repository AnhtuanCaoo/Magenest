<?php
 
namespace Magenest\Movie\Model;
class Movie extends \Magento\Framework\Model\AbstractModel
{   
    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Movie');
        
    }
   

}