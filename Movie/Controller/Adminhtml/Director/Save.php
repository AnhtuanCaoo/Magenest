<?php

namespace Magenest\Movie\Controller\Adminhtml\Director;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\DirectorFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $_directorFactory;

    public function __construct(
        Action\Context $context,
        DirectorFactory $directorFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_directorFactory = $directorFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();

        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('movie/director');
        }

        $newData = [
            'name' => $data['name'],

        ];
        $post = $this->_directorFactory->create();

        if($post){
            $post->setData($newData);
            if (isset($data['director_id'])) {
                $post->setId($data['director_id']);
            }
            try{
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save OK'));
                return $this->resultRedirectFactory->create()->setPath('movie/director/index');
            }catch(\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/director/index');
            }
        }else{
            try{

                $post->addData($newData);
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save ok'));
                return $this->resultRedirect->create()->setPath('movie/director/index');
            }catch (\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/director/index');;
            }
        }

    }
}
