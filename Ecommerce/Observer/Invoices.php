<?php
namespace Magenest\Ecommerce\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\DB\Transaction;

class Invoices implements ObserverInterface
{
    protected $transaction;
    protected $orderFactory;
    protected $invoiceService;
    protected $order;
    protected $logger;
    public function __construct(
        Transaction $transaction,
        OrderFactory $orderFactory,
        InvoiceService $invoiceService,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Api\OrderRepositoryInterface $order
    )
    {
        $this->transaction =$transaction;
        $this->orderFactory = $orderFactory;
        $this->invoiceService = $invoiceService;
        $this->order = $order;
        $this->logger = $logger;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
       $data = $observer->getEvent()->getData('order_ids');
       $id = $data['0'];

       $orderInterface = $this->order->get($id);
       $total = $orderInterface->getBaseGrandTotal();


        if($total == 0){
            $myOrder = $this->orderFactory->create()->load($id)->setStatus('processing');

            $invoices = $this->invoiceService->prepareInvoice($myOrder);
            $invoices->register();
            $invoices->save();
            $transactionSave = $this->transaction->addObject(
                $invoices
            )->addObject(
                $invoices->getOrder()
            );
            $transactionSave->save();
            $this->logger->debug('Created Invoice');
       }else{

            $this->logger->debug('Order okk ');

        }
    }
}
