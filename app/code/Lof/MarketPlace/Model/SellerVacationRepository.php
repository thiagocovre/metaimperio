<?php
namespace Lof\MarketPlace\Model;
use Lof\MarketPlace\Api\SellerVacationRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class SellerVacationRepository implements SellerVacationRepositoryInterface
{
    protected $sellerFactory;
    protected $vacationFactory;
    public function __construct(SellerFactory $sellerFactory, VacationFactory $vacationFactory)
    {
        $this->sellerFactory   = $sellerFactory;
        $this->vacationFactory = $vacationFactory;
    }

    /**
     * GET seller vacation
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerVacation($customerId){
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        if(count($seller)>0){
            $sellerId = $seller->getData()[0]['seller_id'];
        }else{
            throw new NoSuchEntityException(__('This customer account has not register Seller'));
        }
        $res = Config::RES_RESULT;
            $data = $this->vacationFactory->create()->getCollection()->addFieldToFilter('seller_id', $sellerId)->getFirstItem()->getData();
            if($data){
                $data["vacation_id"] = (int)$data["vacation_id"];
                $data["seller_id"] 	 = (int)$data["seller_id"];
                $data["status"] 	 = (int)$data["status"];
            }
            $res = [
                "code" => 0,
                "message" => "Get data success",
                "result" => [
                    "vacation" => $data
                ]
            ];
       return $res;
    }
    /**
     * PUT Vacation
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Lof\MarketPlace\Api\Data\SellerVacationInterface
     */
    public function putSellerVacation(\Lof\MarketPlace\Api\Data\SellerVacationInterface $vacation){
        $res = Config::RES_RESULT;
        if ($vacation) {
                $seller_id = $vacation->getSellerId();
                $vacation_data = $this->vacationFactory->create()->getCollection()
                    ->addFieldToFilter('seller_id', array('eq' => $seller_id))
                    ->getFirstItem()->getData();
                if(empty($vacation_data)){
//                    $data["vacation_id"] = $vacation->getVacationId();
                    $data["seller_id"] = $seller_id;
                    $data["status"] = $vacation->getStatus();
                    $data["vacation_message"] = $vacation->getVacationMessage();
                    $data["from_date"] = $vacation->getFromDate();
                    $data["to_date"] = $vacation->getToDate();
                    $data["text_add_cart"] = $vacation->getTextAddCart();
                    try {
                        $this->vacationFactory->create()->
                        setData($data)->save();
                        $res = [ "code" => 0, "message" => "Save data success"];
                    } catch (Exception $e) {
                        print_r($e->getMessage());
                    }
                }else{
                    throw new NoSuchEntityException(__("Vacation of seller is existed"));
                }

            }
        header('Content-Type: application/json');
       return $res;
    }
}
