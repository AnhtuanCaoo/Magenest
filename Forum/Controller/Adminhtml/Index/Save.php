<?php

namespace Magenest\Forum\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magenest\Forum\Model\PostFactory;
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
        PostFactory $blogFactory,
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
            $this->_redirect('forum/index/index');
        }

        $newData = [
            'author_id' => $data['author_id'],
            'content' => $data['content'],
            'title' => $data['title'],
            'description' => $data['description'],
            'is_active' => $data['is_active'],
            'enable_comment' => $data['enable_comment'],
            'image' => $this->serialize->serialize($data['image'])
        ];

        $post = $this->blogFactory->create();
        if($post){
            $post->setData($newData);

            if (isset($data['post_id'])) {
                $post->setId($data['post_id']);
                try{
                    $post->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save blog ok'));
                    return $this->resultRedirectFactory->create()->setPath('forum/index/index');
                }catch(\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                    return $this->resultRedirect->create()->setPath('forum/index/index');
                }
            }
            else{
                try{
                    $post->addData($newData);
                    $post->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save blog ok'));
                    return $this->resultRedirect->create()->setPath('forum/index/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save blog failed.'));
                    return $this->resultRedirect->create()->setPath('forum/index/index');
                }
            }
        }


    }
}
