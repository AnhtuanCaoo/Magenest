<?php

namespace Magenest\Movie\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class ConfigChange implements ObserverInterface
{
    // const XML_PATH_FAQ_URL = 'faqtab/general/faq_url';

    /**
     * @var RequestInterface
     */
    private $request;
	protected $logger;
    protected $_configWriter;
    protected $_customerInterface;
    /**
     * ConfigChange constructor.
     * @param RequestInterface $request
     * @param WriterInterface $configWriter
     */
    public function __construct(
        RequestInterface $request,
        WriterInterface $configWriter,
        \Psr\Log\LoggerInterface $logger,
        CustomerRepositoryInterface $customerRepositoryInterface

    ) {
        $this->_customerInterface = $customerRepositoryInterface;
        $this->logger = $logger;
        $this->request = $request;
        $this->_configWriter = $configWriter;

    }

    public function execute(EventObserver $observer)
    {
       $this->logger->debug('okkkkkkkkkkkkkkk');
       $groups = $this->request->getParam('groups');
       $text = $groups['magenest_movie']['fields']['text_field']['value'];
    //    $this->logger->debug($text);
        if($text == 'Ping'){
            $text = 'Pong';
            $this->_configWriter->delete('movie/magenest_movie/text_field');
            $this->_configWriter->save('movie/magenest_movie/text_field',$text);
        }
        
       
       
       
    }
}