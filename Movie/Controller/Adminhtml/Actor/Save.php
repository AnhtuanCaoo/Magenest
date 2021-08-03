<?php

namespace Magenest\Movie\Controller\Adminhtml\Actor;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\ActorFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $_actorFactory;

    public function __construct(
        Action\Context $context,
        ActorFactory $actorFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->_actorFactory = $actorFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('movie/actor');
        }

        $newData = [
            'name' => $data['name'],

        ];
        $post = $this->_actorFactory->create();
        if($post){
            $post->setData($newData);
            if (isset($data['actor_id'])) {
                $post->setId($data['actor_id']);
            }
            try{
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save OK'));
                return $this->resultRedirectFactory->create()->setPath('movie/actor/index');
            }catch(\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/actor/index');
            }

        }else{
            try{

                $post->addData($newData);
                $post->save();
                $this->getMessageManager()->addSuccessMessage(__('Save ok'));
                return $this->resultRedirect->create()->setPath('movie/actor/index');
            }catch (\Exception $e){
                $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                return $this->resultRedirect->create()->setPath('movie/actor/index');
            }
        }


    }
}
