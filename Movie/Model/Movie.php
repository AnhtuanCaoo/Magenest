<?php
 
namespace Magenest\Movie\Model;
class Movie extends \Magento\Framework\Model\AbstractModel
{   
    protected $_eventPrefix = 'movie_model';


    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Movie');
        
    }
   
    

}