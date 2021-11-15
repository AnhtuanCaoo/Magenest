<?php
namespace Magenest\GoogleShopping\Model;

use Magenest\GoogleShopping\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Adapter\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\UrlInterface;

/**
 * Class Client
 * @package Magenest\GoogleShopping\Model
 */
class Client
{
    const URI = 'https://www.googleapis.com';
    const VERSION = 'v2.1';

    protected $_googleClient = null;

    /** @var Json  */
    protected $_jsonFramework;

    /** @var CurlFactory  */
    protected $_curlFactory;

    /** @var UrlInterface  */
    protected $_url;

    /** @var ScopeConfigInterface  */
    protected $_scopeConfig;

    /** @var ComponentRegistrar  */
    protected $_componentRegistrar;

    /**
     * Client constructor.
     * @param Json $jsonFramework
     * @param CurlFactory $curlFactory
     * @param UrlInterface $url
     * @param ScopeConfigInterface $scopeConfig
     * @param ComponentRegistrar $componentRegistrar
     */
    public function __construct(
        Json $jsonFramework,
        CurlFactory $curlFactory,
        UrlInterface $url,
        ScopeConfigInterface $scopeConfig,
        ComponentRegistrar $componentRegistrar
    ) {
        $this->_jsonFramework = $jsonFramework;
        $this->_curlFactory = $curlFactory;
        $this->_url = $url;
        $this->_scopeConfig = $scopeConfig;
        $this->_componentRegistrar = $componentRegistrar;
    }

    /**
     * @param $url
     * @param string $method
     * @param array $params
     * @return array|bool|float|int|mixed|string|null
     * @throws LocalizedException
     */
    protected function _httpRequest($url, $method = 'GET', $params = [])
    {
        /** @var  $curl */
        $curl = $this->_curlFactory->create();
        $curl->setConfig([
            'timeout'   => 2,
            'useragent' => 'Magenest Google Shopping',
            'referer'   => $this->_url->getUrl('*/*/*')
        ]);
        $headers = ["Content-Type" => "application/json", "Content-Length" => "2000"];
        switch ($method) {
            case 'GET':
                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
                $curl->write($method, $url);
                break;
            case 'POST':
                $curl->write($method, $url, '1.1', $headers, $params);
                break;
        }
        $response = $curl->read();
        $curl->close();
        if ($response === false) {
            throw new LocalizedException(__('HTTP error occurred while issuing request. Please contact Administrator for more information.'));
        }
        $response = preg_split('/^\r?$/m', $response, 2);
        if (count($response) != 2) {
            $decodedResponse = trim($response[0]);
        } else {
            $response        = trim($response[1]);
            $decodedResponse = $this->_jsonFramework->unserialize($response);
        }
        if (is_array($decodedResponse) && !empty($decodedResponse)) {
            if (isset($decodedResponse['error'])) {
                $error = $decodedResponse['error'];
                throw new LocalizedException(__(implode(', ', $error)));
            }
            if (isset($decodedResponse['data'])) {
                // reverser list photo to arrange the latest photos for the highest id
                $decodedResponse['data'] = array_reverse($decodedResponse['data']);
            }
            return $decodedResponse;
        } else {
            return [];
        }
    }

    public function makeRequest($method, $url, $accessToken = [], $params = [])
    {
        $headers = ["Content-Type" => "application/json"];
        if (is_array($accessToken) && isset($accessToken['access_token'])) {
            $headers = array_merge($headers, ["Authorization" => "Bearer " . $accessToken['access_token']]);
        }
        $client = new \Zend_Http_Client($url);
        $client->setHeaders($headers);
        if ($method != \Zend_Http_Client::GET) {
            $client->setParameterPost($params);
            if (isset($headers['Content-Type']) && $headers['Content-Type'] == 'application/json') {
                $client->setEncType('application/json');
                $params = $this->_jsonFramework->serialize($params);
                $client->setRawData($params);
            }
        }
        $response = $client->request($method)->getBody();
        return $response;
    }

    public function getAccountInfo($accessToken)
    {
        //api: content/v2.1/accounts/authinfo
        $endpoint = self::URI . "/content/" . self::VERSION . "/accounts/authinfo";

//        $accessToken = $this->getStoreConfig(Data::GOOGLE_TOKEN);
        $query = [
            'access_token' => "$accessToken"
        ];
        $url = $endpoint . '?' . http_build_query($query);
        $response = $this->_httpRequest($url);
        $accountIdentifiers = [];
        if (is_array($response) && isset($response['accountIdentifiers']) && !empty($response['accountIdentifiers'])) {
            $accountIdentifiers = reset($response['accountIdentifiers']);
        }
        return $accountIdentifiers;
    }

    public function getProductBath()
    {
        //api: content/v2.1/products/batch
        $endpoint = self::URI . "/content/" . self::VERSION . "/products/batch";
        $accessToken = $this->getStoreConfig(Data::GOOGLE_TOKEN);
        $query = [
            'access_token' => "$accessToken"
        ];
        $url = $endpoint . '?' . http_build_query($query);
        $response = $this->_httpRequest($url, 'POST');
    }

    public function insertProduct($paramter)
    {
        //api: content/v2.1/{merchantId}/products
        $accessToken = $this->getAccessToken();
        $merchantId = $this->getStoreConfig(Data::MERCHANT_ID);
        $endpoint = self::URI . "/content/" . self::VERSION . "/" . $merchantId . "/products";
        $response = $this->makeRequest(\Zend_Http_Client::POST, $endpoint, $accessToken, $paramter);
        return $this->handleResponse($response);
    }

    /**
     * @param $response
     * @return array|bool|float|int|mixed|string|null
     * @throws \Exception
     */
    public function handleResponse($response)
    {
        try {
            $response = $this->_jsonFramework->unserialize($response);
            return $response;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
    /**
     * @param $xmlPath
     * @return mixed
     */
    public function getStoreConfig($xmlPath)
    {
        return $this->_scopeConfig->getValue($xmlPath);
    }

    /**
     * @return array
     * @throws \Google_Exception
     */
    private function getAccessToken()
    {
        $accessToken = $this->getStoreConfig(Data::GOOGLE_TOKEN);
        $refreshToken = $this->getStoreConfig(Data::GOOGLE_REFRESH_TOKEN);
        $expiresIn = $this->getStoreConfig(Data::GOOGLE_TOKEN_EXPIRESIN);
        $data = [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => $expiresIn
        ];
        $googleClientModel = $this->getGoogleClientModel();
        $googleClientModel->setAccessToken($data);
        if ($googleClientModel->isAccessTokenExpired()) {
            $refreshToken = $this->getStoreConfig(Data::GOOGLE_REFRESH_TOKEN);
            $googleClientModel->refreshToken($refreshToken);
        }
        return $googleClientModel->getAccessToken();
    }

    /**
     * @return \Google_Client
     * @throws \Google_Exception
     */
    private function getGoogleClientModel()
    {
        if ($this->_googleClient == null) {
            $client = new \Google_Client();
            $clientSecretJson = $this->_componentRegistrar->getPath('module', 'Magenest_GoogleShopping') . '/lib/client_secret.json';
            $client->setAuthConfig($clientSecretJson);
            $this->_googleClient = $client;
        }
        return $this->_googleClient;
    }

    public function productCustomBath($products)
    {
        //api: content/v2.1/products/batch
        $merchantId = $this->getStoreConfig(Data::MERCHANT_ID);
        $entries = [];
        $i = 0;
        foreach ($products as $product) {
            $entries[] = [
                "batchId" => $i,
                "merchantId" => $merchantId,
                "method" => "insert",
                "product" => $product
            ];
            $i++;
        }
        $paramter = [
            "entries" => $entries
        ];
        $endpoint = self::URI . "/content/" . self::VERSION . "/products/batch";
        $accessToken = $this->getAccessToken();
        return $this->makeRequest(\Zend_Http_Client::POST, $endpoint, $accessToken, $paramter);
    }

    /**
     * @param $productIds
     * @return array|bool|float|int|mixed|string|null
     * @throws \Exception
     */
    public function productStatusBath($productIds)
    {
        //api: content/v2.1/productstatuses/batch
        $merchantId = $this->getStoreConfig(Data::MERCHANT_ID);
        $entries = [];
        $i = 0;
        foreach ($productIds as $productId) {
            $entries[] = [
                "batchId" => $i,
                "merchantId" => $merchantId,
                "method" => "get",
                "productId" => $productId,
                "includeAttributes" => true
            ];
            $i++;
        }
        $paramter = [
            "entries" => $entries
        ];
        $endpoint = self::URI . "/content/" . self::VERSION . "/productstatuses/batch";
        $accessToken = $this->getAccessToken();
        $response = $this->makeRequest(\Zend_Http_Client::POST, $endpoint, $accessToken, $paramter);
        return $this->handleResponse($response);
    }
}
