<?php

namespace Magenest\Movie\Controller\Adminhtml\MovieActor;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\MovieActorFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $_movieactorFactory;

    public function __construct(
        Action\Context $context,
        MovieActorFactory $movieactorFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_movieactorFactory = $movieactorFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        
        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('movie/movieactor');
        }

        $newData = [
            'movie_id' => $data['movie_id'],
            'actor_id' => $data['actor_id'],

        ];
        $post = $this->_movieactorFactory->create();

        if($post){
            $post->setData($newData);
            if (isset($data['id_table'])) {
                $post->setId($data['id_table']);
            }
            try{
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save OK'));
                return $this->resultRedirectFactory->create()->setPath('movie/movieactor/index');
            }catch(\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/movieactor/index');
            }
           
        }else{
            try{
            
                $post->addData($newData);
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save ok'));
                return $this->resultRedirect->create()->setPath('movie/movieactor/index');
            }catch (\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/movieactor/index');
            }
        }
        
    }
}