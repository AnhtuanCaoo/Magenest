<?php

namespace Magenest\Forum\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magenest\Forum\Model\PostFactory;

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

    /** @var PostFactory  */
    protected $postFactory;


    /**
     * @param PostFactory $bannerFactory
     * @param Json $serialize
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        PostFactory $postFactory,
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
        $this->postFactory= $postFactory;
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
                if(isset($item['post_id'])) {
                    $postModel = $this->postFactory->create()->load($item['post_id']);
                    try {
                        $image = $this->serialize->unserialize($postModel->getData('image'));
                        $item[$fieldName . '_src'] = $image[0]['url'];
                        $item[$fieldName . '_orig_src']= $image[0]['url'];

                    }catch (\Exception $e){
                        $item['image'] = '';
                    }
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        'forum/index/add',['post_id'=>$item['post_id']]
                    );
                }
            }
        }
        return $dataSource;
    }
}
