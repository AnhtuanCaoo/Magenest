<?php

namespace Magenest\Frontend\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magenest\Frontend\Model\BannerFactory;
use Magenest\Frontend\Model\ResourceModel\Banner as BannerResource;

/**
 * Class Image
 * @package Magenest\NotificationBox\Ui\Component\Listing\Columns
 */
class Images extends \Magento\Ui\Component\Listing\Columns\Column
{
    const NAME = 'image';

    const ALT_FIELD = 'name';

    /** @var string default icon directory url */

    /** @var \Magento\Catalog\Helper\Image  */
    protected $imageHelper;

    /** @var \Magento\Framework\UrlInterface  */
    protected $urlBuilder;

    /** @var Json  */
    protected $serialize;

    /** @var BannerFactory  */
    protected $bannerFactory;

    /** @var BannerResource  */
    protected $bannerResource;
    /**
     * @param BannerFactory $bannerFactory
     * @param BannerResource $bannerResource
     * @param Json $serialize
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        BannerFactory $bannerFactory,
        BannerResource $bannerResource,
        Json $serialize,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->imageHelper  = $imageHelper;
        $this->urlBuilder   = $urlBuilder;
        $this->serialize    = $serialize;
        $this->bannerFactory= $bannerFactory;
        $this->bannerResource = $bannerResource;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getName();
            foreach ($dataSource['data']['items'] as & $item) {
                if(isset($item['id'])) {
                    $bannerModel = $this->bannerFactory->create()->load($item['id']);
                        try {
                            $image = $this->serialize->unserialize($bannerModel->getImages());
                            $item[$fieldName . '_src'] = $image[0]['url'];
                            $item[$fieldName . '_orig_src']= $image[0]['url'];

                        }catch (\Exception $e){
                            $item['image'] = '';
                        }
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        'frontend/banner/add',['id'=>$item['id']]
                    );
                }
            }
        }
        return $dataSource;
    }
}
