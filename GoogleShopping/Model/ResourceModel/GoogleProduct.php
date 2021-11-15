<?php
namespace Magenest\GoogleShopping\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Framework\Serialize\Serializer\Json as JsonFramework;

class GoogleProduct extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /** @var JsonFramework  */
    protected $_jsonFramework;

    /** @var \Magento\Framework\DB\Adapter\AdapterInterface */
    protected $_connection;

    public function __construct(
        JsonFramework $jsonFramework,
        Context $context,
        $connectionName = null
    ) {
        $this->_jsonFramework = $jsonFramework;
        parent::__construct($context, $connectionName);
    }

    public function _construct()
    {
        $this->_init('magenest_google_feed_product', 'id');
        $this->_connection = $this->getConnection();
    }

    /**
     * @param array $array
     * @param array $fields
     * @throws \Exception
     */
    public function insertData($array = [], $fields = [])
    {
        try {
            $mappTable = $this->getMainTable();
            if (is_array($array) && !empty($array)) {
                $this->_connection->insertOnDuplicate(
                    $mappTable,
                    $array,
                    $fields
                );
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $feedId
     * @return array
     * @throws \Exception
     */
    public function getOfferIdsByFeedId($feedId)
    {
        try {
            $select = $this->_connection->select()->from($this->getMainTable(), 'google_product')
                ->where('feed_id = :feed_id');
            return $this->_connection->fetchCol($select, [':feed_id' => $feedId]);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $responses
     * @param $feedId
     * @param string $type
     * @throws \Exception
     */
    public function saveGoogleProductStatus($responses, $feedId, $type = 'product')
    {
        if (is_array($responses) && !empty($responses)) {
            foreach ($responses as $responseRaw) {
                $entries = [];
                if (is_array($responseRaw) && isset($responseRaw['entries'])) {
                    $entries = $responseRaw['entries'];
                }
                $this->saveProduct($entries, $feedId);
            }
        }
    }

    /**
     * @param $entries
     * @param $feedId
     * @throws \Exception
     */
    private function saveProduct($entries, $feedId)
    {
        try {
            $fields = ['feed_id', 'kind', 'google_product', 'offerId', 'contentLanguage', 'targetCountry', 'channel'];
            foreach ($entries as $response) {
                $googleProduct = $response['product'] ?? '';
                if ($googleProduct == '') {
                    continue;
                }
                $googleProduct['google_product'] = $googleProduct['id'];
                $googleProduct['feed_id'] = $feedId;
                unset($googleProduct['id']);
                $this->insertData($googleProduct, $fields);
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param $responseEncode
     * @param $feedId
     * @throws \Exception
     */
    public function saveStatus($responseEncode, $feedId)
    {
        try {
            if (isset($responseEncode["error"])) {
                throw new \Exception($responseEncode["error"]['message']);
            }
            $entries = [];
            if (is_array($responseEncode) && isset($responseEncode['entries'])) {
                $entries = $responseEncode['entries'];
            }
            $fields = ['feed_id', 'google_product', 'status'];
            foreach ($entries as $respons) {
                $googleProductStatus = $respons['productStatus'] ?? '';
                $googleProduct = [];
                if ($googleProductStatus == '') {
                    continue;
                }
                $googleProduct['google_product'] = $googleProductStatus['productId'];
                $googleProduct['feed_id'] = $feedId;
                $destinationStatuses = isset($googleProductStatus['destinationStatuses']) ? $googleProductStatus['destinationStatuses'] : [];
                if (isset($googleProductStatus['destinationStatuses'])) {
                    $statuses = reset($destinationStatuses);
                    $googleProduct['status']  = $statuses['status'];
                    if (isset($googleProductStatus['itemLevelIssues'])) {
                        $googleProduct['message'] = $this->_jsonFramework->serialize($googleProductStatus['itemLevelIssues']);
                        $fields[] = 'message';
                    }
                }
                $this->insertData($googleProduct, $fields);
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
