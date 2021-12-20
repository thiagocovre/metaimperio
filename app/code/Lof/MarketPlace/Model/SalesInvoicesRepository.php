<?php
namespace Lof\MarketPlace\Model;
use Lof\MarketPlace\Api\SalesInvoicesRepositoryInterface;
use Lof\MarketPlace\Model\InvoiceFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class SalesInvoicesRepository implements SalesInvoicesRepositoryInterface
{
       protected  $sellerFactory;
       protected  $invoiceFactory;
        public function __construct( SellerFactory $sellerFactory,InvoiceFactory $invoiceFactory)
        {
            $this->sellerFactory = $sellerFactory;
            $this->invoiceFactory = $invoiceFactory;
        }

    /**
     * GET seller invoice
     * @param int $customerId
     * @return string
     *@throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerInvoices($customerId){

        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        if(count($seller->getData())>0)
        {
            $seller_id = $seller->getData()[0]['seller_id'];
        }
        else{
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $res = [
            "code" => 405,
            "message" => "Get data failed"
        ];
            $data = $this->invoiceFactory->create()->getCollection()->addFieldToFilter('seller_id',$seller_id)->getData();
            if($data){
                $res["code"] = 0;
                $res["message"] = "get data success!";
                $res["result"]["invoices"][] = $data;
            }else{
                $res["code"] = 0;
                $res["message"] = "get data success!";
                $res["result"]["invoices"] = [];
            }
       return $res;
    }
    /**
     * GET seller invoice by id
     * @param string $InvoiceId
     * @param string $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerInvoicesByID($InvoiceId, $customerId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        if(count($seller->getData())>0)
        {
            $seller_id = $seller->getData()[0]['seller_id'];
        }
        else{
            throw new NoSuchEntityException(__('Customer has not registered the seller yet'));
        }
        $res = ["code" => 405, "message" => "Get data failed"];
        $invoice_data =  $this->invoiceFactory->create()->getCollection()
            ->addFieldToFilter('seller_id', array('eq' => $seller_id))
            ->addFieldToFilter('invoice_id',array('eq' => $InvoiceId))->getFirstItem()->getData();
            if($invoice_data){
                try {
                    $seller_order_items = $objectManager->create ('Lof\MarketPlace\Model\Orderitems');
                    $product = $seller_order_items->getCollection()
                        ->addFieldToFilter('seller_id', array('eq' => $seller_id))
                        ->addFieldToFilter('order_id', array('eq' => $invoice_data['seller_order_id']))
                        ->loadData()->getData();
                    $invoice_data["product_list"] = $product;
                    $res["code"] = 0;
                    $res["message"] = "get data success!";
                    $res["result"]["order"] = $invoice_data;
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }
        return $res;
    }
}