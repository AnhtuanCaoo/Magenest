<?php

namespace Magenest\Forum\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use Magenest\Forum\Model\CommentFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Serialize\Serializer\Json;

class Save extends Action
{
    private $resultRedirect;
    private $blogFactory;
    private $serialize;
    public function __construct(
        Json $serialize,
        Action\Context $context,
        CommentFactory $blogFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->serialize = $serialize;
        $this->blogFactory = $blogFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();

        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('forum/comment/index');
        }

        $newData = [
            'post_id' => $data['post_id'],
            'message' => $data['message'],
            'user_id' => $data['user_id']
        ];

        $post = $this->blogFactory->create();
        if($post){
            $post->setData($newData);

            if (isset($data['comment_id'])) {
                $post->setId($data['comment_id']);
                try{
                    $post->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save comment ok'));
                    return $this->resultRedirectFactory->create()->setPath('forum/comment/index');
                }catch(\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                    return $this->resultRedirect->create()->setPath('forum/comment/index');
                }
            }
            else{
                try{
                    $post->addData($newData);
                    $post->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save comment ok'));
                    return $this->resultRedirect->create()->setPath('forum/comment/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save comment failed.'));
                    return $this->resultRedirect->create()->setPath('forum/comment/index');
                }
            }
        }


    }
}
