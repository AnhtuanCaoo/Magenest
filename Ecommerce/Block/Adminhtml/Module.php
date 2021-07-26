<?php
namespace Magenest\Ecommerce\Block\Adminhtml;
use Magento\Backend\Block\Template;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Customer\Model\Customer;
use Magento\Framework\Module\ModuleList;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderFactory;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceFactory;
use Magento\Sales\Model\ResourceModel\Order\Creditmemo\CollectionFactory as CreditmemoFactory;
class Module extends Template
{
    protected $creditmemoFactory;
    protected $invoiceFactory;
    protected $orderFactory;
    protected $moduleList;
    protected $customer;
    protected $customerFactory;
    protected $productFactory;
    public function __construct(
        Template\Context $context,
        CreditmemoFactory $creditmemoFactory,
        InvoiceFactory $invoiceFactory,
        OrderFactory $orderFactory,
        ProductFactory $productFactory,
        ModuleList $moduleList,
        Customer $customer,
        CollectionFactory $customerFactory,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->creditmemoFactory = $creditmemoFactory;
        $this->invoiceFactory = $invoiceFactory;
        $this->orderFactory = $orderFactory;
        $this->productFactory =$productFactory;
        $this->moduleList = $moduleList;
        $this->customer = $customer;
        $this->customerFactory = $customerFactory;
    }
    public function getModuleNotInMagento(){
        $magento = $this->moduleList->getAll();
        $count = 0;
        $lastModule = $this->getModuleList();
        foreach($magento as $value) {
        $tmp = explode('_', $value['name']);
        if ($tmp[0] == 'Magento'){
            $count++;
            }
        }
        return ($lastModule - $count);
    }
    public function getCreditmemo(){
        $creditmemo = $this->creditmemoFactory->create();
        return $this->getNumber($creditmemo);
    }
    public function getInvoice(){
        $invoice = $this->invoiceFactory->create();
        return $this->getNumber($invoice);
    }
    public function getOrder(){
        $order = $this->orderFactory->create();
        return $this->getNumber($order);
    }
    public function getModuleList(){
        $module = $this->moduleList->getAll();
        return $this->getNumber($module);
    }

    public function getProduct(){
        $product = $this->productFactory->create();
        return $this->getNumber($product);
    }

    public function getCustomername() {

        $customerName = $this->customerFactory->create();
        return $this->getNumber($customerName);
    }

    public function getNumber($tmp){
        $count = 0;
        foreach($tmp as $value){
            $count++;
        }
        return $count;
    }
}
