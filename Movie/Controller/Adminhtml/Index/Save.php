<?php

namespace Magenest\Movie\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magenest\Movie\Model\MovieFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;

class Save extends Action
{
    private $resultRedirect;
    private $movieFactory;

    public function __construct(
        Action\Context $context,
        MovieFactory $movieFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        try{

            $data = $this->getRequest()->getPostValue();
            // var_dump($data);

            if(!$data){
                $this->_redirect('movie');
            }

            $newData = [
                'name' => $data['name'],
                'description' => $data['description'],
                'rating' => $data['rating'],
                'director_id' => $data['director_id'],

            ];
            $post = $this->movieFactory->create();

            if($post){
                $post->setData($newData);
                if (isset($data['movie_id'])) {
                    $post->setId($data['movie_id']);
                    try{
                        // $this->_eventManager->dispatch('save_movie', ['save_event' => $post]);

                        $post->save();
                        $this->getMessageManager()->addSuccessMessage(__('Edit OK'));
                        return $this->resultRedirectFactory->create()->setPath('movie/index/index');
                    }catch(\Exception $e){
                        $this->getMessageManager()->addErrorMessage(__('Edit failed.'));
                        return $this->resultRedirect->create()->setPath('movie/index/index');
                    }
                }else{
                    try{
                        // $this->_eventManager->dispatch('save_movie', ['save_event' => $post]);

                        $post->save();
                        $this->getMessageManager()->addSuccessMessage(__(' OK'));
                        return $this->resultRedirectFactory->create()->setPath('movie/index/index');
                    }catch(\Exception $e){
                        $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                        return $this->resultRedirect->create()->setPath('movie/index/index');
                    }
                }
            }else{
                try{

                    $post->addData($newData);
                    $post->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save ok'));
                    return $this->resultRedirect->create()->setPath('movie/index/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                    return $this->resultRedirect->create()->setPath('movie/index/index');
                }
            }
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save failed.'));
            return $this->resultRedirect->create()->setPath('movie/index/index');
        }

    }
}
