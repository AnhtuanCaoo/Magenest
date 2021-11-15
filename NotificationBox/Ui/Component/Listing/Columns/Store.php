<?php

namespace Magenest\NotificationBox\Ui\Component\Listing\Columns;

use Magento\Framework\Escaper;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Api\StoreManagementInterface;
use Magento\Store\Model\System\Store as SystemStore;
use Magento\Framework\Serialize\Serializer\Json;

class Store extends \Magento\Store\Ui\Component\Listing\Column\Store
{
    /** @var Json */
    protected $serialize;
    /**
     * Construct
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     * @param Json $serialize
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SystemStore $systemStore,
        Escaper $escaper,
        Json $serialize,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $systemStore, $escaper, $components, $data, 'store_ids');
        $this->serialize = $serialize;
    }

    /**
     * Prepare item
     *
     * @param array $item
     * @return Phrase|string
     */
    protected function prepareItem(array $item)
    {
        if (isset($item['store_view'])) {
            try {

                $item['store_view'] = $this->serialize->unserialize($item['store_view']);
            } catch (\Exception $exception) {
                $item['store_view'] ='';
            }

        }
        $content = '';
        if ($item['store_view'] !== null) {
            $origStores = $item['store_view'];

            if (!is_array($origStores)) {
                $origStores = explode(',', $origStores);
            }
            if (in_array(0, $origStores)) {
                return __('All Store Views');
            }

            $data = $this->systemStore->getStoresStructure(false, $origStores);

            foreach ($data as $website) {
                $content .= '<b>' . $website['label'] . "</b><br/>";
                foreach ($website['children'] as $group) {
                    $content .= str_repeat('&nbsp;', 3) . '<b>' . $this->escaper
                            ->escapeHtml($group['label']) . '</b>' . "<br/>";
                    foreach ($group['children'] as $store) {
                        $content .= str_repeat('&nbsp;', 6) . $this->escaper
                                ->escapeHtml($store['label']) . "<br/>";
                    }
                }
            }
        }
        return $content;
    }

    /**
     * Prepare data source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item['store_view'] = $this->prepareItem($item);
            }
        }
        return $dataSource;
    }
}
