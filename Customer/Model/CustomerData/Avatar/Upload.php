<?php
namespace Magenest\Customer\Model\CustomerData\Avatar;
use Exception;
use Magento\Framework\App\Filesystem\DirectoryList;
use \Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magenest\Customer\Model\CustomerData\Avatar;
class Upload extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend
{
    protected $request;
    protected $filesystem;
    protected $uploaderFactory;
    protected $storeManager;
    protected $coreFileStorageDatabase;
    public function __construct(
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        UploaderFactory $uploaderFactory,
        Database $coreFileStorageDatabase,
        RequestInterface $request
    )
    {
        $this->coreFileStorageDatabase = $coreFileStorageDatabase;
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->request = $request;
    }

    public function beforeSave($object)
   {
       $validation = new Image();
       $attrCode = $this->getAttribute()->getAttributeCode();
       if ($attrCode == 'avatar') {
           if ($validation->isImageValid('tmp_name', $attrCode) === false) {
               throw new \Magento\Framework\Exception\LocalizedException(
                   __('The profile picture is not a valid image.')
               );
           }
       }
//       $customer_params = $this->request->getParam('customer');
//        $avatar = $customer_params['avatar'][0];


       return parent::beforeSave($object); // TODO: Change the autogenerated stub
   }


}
