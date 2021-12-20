<?php
namespace Lof\MarketPlace\Model;
class SellerRatingsRepository implements \Lof\MarketPlace\Api\SellerRatingsRepositoryInterface
{
    protected $_objectManager;
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        $this->_objectManager = $objectManager;
    }
    /**
     * @param $seller_id
     * GET seller ratings
     * @return mixed
     */
    public function getSellerRatings($seller_id)
    {
        $sellerrating = $this->_objectManager->get("Lof\MarketPlace\Model\Rating");
        $data = $sellerrating->getCollection()->addFieldToFilter('seller_id',$seller_id)->getData();
        foreach ($data as &$value) {
            $value["rating_id"]         = (int)$value["rating_id"];
            $value["seller_id"]         = (int)$value["seller_id"];
            $value["customer_id"]       = (int)$value["customer_id"];
            $value["rate1"]             = (int)$value["rate1"];
            $value["rate2"]             = (int)$value["rate2"];
            $value["rate3"]             = (int)$value["rate3"];
            $value["rating"]            = (int)$value["rating"];
        }
        $res = [
            "code" => 0,
            "message" => "Get data success",
            "result" => [
                "rating" => $data
            ]
        ];
        return $res;
    }
    /**
     * GET seller rating by id
     * @param int $id
     * @return mixed
     */
    public function getSellerRatingsByID($id)
    {
        $sellerrating = $this->_objectManager->get("Lof\MarketPlace\Model\Rating");
        $data = $sellerrating->getCollection()->addFieldToFilter('seller_id',$id)->getData();
        foreach ($data as &$value) {
            $value["rating_id"]         = (int)$value["rating_id"];
            $value["seller_id"]         = (int)$value["seller_id"];
            $value["customer_id"]       = (int)$value["customer_id"];
            $value["rate1"]             = (int)$value["rate1"];
            $value["rate2"]             = (int)$value["rate2"];
            $value["rate3"]             = (int)$value["rate3"];
            $value["rating"]            = (int)$value["rating"];
        }
        $res = [
            "code" => 0,
            "message" => "Get data success",
            "result" => [
                "rating" => $data
            ]
        ];
        return $res;
    }
}