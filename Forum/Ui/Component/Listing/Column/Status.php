<?php

namespace Magenest\Forum\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class OrderId
 * Modifies the column Order id
 */
class Status extends Column
{

    protected $logger;
    /**
     * Order Id constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param string[] $components
     * @param string[] $data
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->logger = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['is_active'])) {
                    if($item['is_active'] == 1){
                        $html = "<div class='active'>";
                        $html .= "Enable";
                        $html .= "</div>";

                    }else{
                        $html = "<div class='not_active'>";
                        $html .= "Disable";
                        $html .= "</div>";
                    }
                    $item['is_active'] = $html;

                }
            }
        }
        return $dataSource;
    }
}
