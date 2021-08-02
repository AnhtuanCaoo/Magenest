<?php

namespace Magenest\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magenest\Blog\Model\BlogFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;

class Save extends Action
{
    private $resultRedirect;
    private $blogFactory;
    protected $urlRewrite;
    protected $urlRewriteCollectionFactory;
    public function __construct(
        Action\Context $context,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory,
        UrlRewriteFactory $urlRewrite,
        BlogFactory $blogFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
        $this->urlRewrite = $urlRewrite;
        $this->blogFactory = $blogFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('blog/blog');
        }

        $newData2 = [
            'author_id' => $data['author_id'],
            'content' => $data['content'],
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'url_rewrite' => $data['url_rewrite'],



        ];
        $blog = $this->blogFactory->create();

        if($blog){
            $blog->setData($newData2);

            if (isset($data['id'])) {
                $blog->setId($data['id']);
                try{
                    $url_rewrite = $this->blogFactory->create()->load($data['id'])->getData('url_rewrite');
                    if(isset($url_rewrite)){
                        $blog->setData('url_rewrite', $url_rewrite);
                    }
                    $blog->save();
                    $rewrite = $blog->getData('url_rewrite');
                    $idBlog = $blog->getData('id');
                    $url = $this->urlRewrite->create();
                    $tmp = $this->urlRewriteCollectionFactory->create()->getColumnValues('request_path');

                    if(!in_array($rewrite,$tmp, true)){
                        $url->setEntityType('custom');
                        $url->setStoreId(1);
                        $url->setTargetPath('blog/view/id/'.$idBlog);
                        $url->setRequestPath($rewrite);
                        $url->save();
                    }

                    $this->getMessageManager()->addSuccessMessage(__('Save OK'));
                    return $this->resultRedirectFactory->create()->setPath('blog/blog/index');
                }catch(\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                    return $this->resultRedirect->create()->setPath('blog/blog/index');
                }
            }
            else{
                try{

                    $blog->addData($newData2);
                    $blog->save();
                    $rewrite = $blog->getData('url_rewrite');
                    $idBlog = $blog->getData('id');
                    $url = $this->urlRewrite->create();
                    $url->setEntityType('custom');
                    $url->setStoreId(1);
                    $url->setTargetPath('blog/view/id/'.$idBlog);
                    $url->setRequestPath($rewrite);
                    $url->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save blog ok'));
                    return $this->resultRedirect->create()->setPath('blog/blog/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save blog failed.'));
                    return $this->resultRedirect->create()->setPath('blog/blog/index');
                }
            }


        }


    }
}
