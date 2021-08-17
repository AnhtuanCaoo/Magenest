<?php

namespace Magenest\Frontend\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magenest\Frontend\Model\BannerFactory;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Serialize\Serializer\Json;


class Save extends Action
{
    private $resultRedirect;
    private $bannerFactory;
    private $serialize;
    public function __construct(
        Action\Context $context,
        Json $serialize,
        BannerFactory $bannerFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->bannerFactory = $bannerFactory;
        $this->serialize = $serialize;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {

        $data = $this->getRequest()->getPostValue();
        // var_dump($data);
        // die();
        if(!$data){
            $this->getMessageManager()->addErrorMessage(__('Fail'));
            $this->_redirect('frontend/banner');
        }
        if (isset($data['images'])) {
            $data['images'] = $this->serialize->serialize($data['images']);
            //$model->setData($data);
        }
        $newData = [
            'enabled' => $data['enabled'],
            'name' => $data['name'],
            'title' => $data['title'],
            'link' => $data['link'],
            'add_text' => $data['add_text'],
            'images' => $data['images']


        ];
        $banner = $this->bannerFactory->create();

        if($banner){
            $banner->setData($newData);

            if (isset($data['id'])) {
                $banner->setId($data['id']);
                try{
                    $banner->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save OK'));
                    return $this->resultRedirectFactory->create()->setPath('frontend/banner/index');
                }catch(\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save failed.'));
                    return $this->resultRedirect->create()->setPath('frontend/banner/index');
                }
            }
            else{
                try{
                    $banner->addData($newData);
                    $banner->save();
                    $this->getMessageManager()->addSuccessMessage(__('Save banner ok'));
                    return $this->resultRedirect->create()->setPath('frontend/banner/index');
                }catch (\Exception $e){
                    $this->getMessageManager()->addErrorMessage(__('Save banner failed.'));
                    return $this->resultRedirect->create()->setPath('frontend/banner/index');
                }
            }


        }


    }
}
