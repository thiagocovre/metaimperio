<?php

namespace Lof\MarketPlace\Model;

use Lof\MarketPlace\Api\Data\SellersSearchResultsInterfaceFactory;
use Lof\MarketPlace\Api\SellersFrontendRepositoryInterface;

class SellersFrontendRepository implements SellersFrontendRepositoryInterface
{
    protected  $_seller;

    protected $searchResultsFactory;

    protected $_storeManager;

    protected $_objectManager;
    protected $sellerProduct;

    public function __construct(
        \Lof\MarketPlace\Model\Seller $seller,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\ObjectManagerInterface $objectManager, 
        SellersSearchResultsInterfaceFactory $searchResultsFactory,
        SellerProduct $sellerProduct
        ) {
        $this->_seller = $seller;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->_storeManager = $storeManager;
        $this->_objectManager = $objectManager;
        $this->sellerProduct = $sellerProduct;
    }

    public function getById($seller_id){
        $res = Config::RES_RESULT; 
        if($seller_id){
            $collection = $this->_seller->getCollection();
            $collection->addFieldToFilter("seller_id", $seller_id);
            $data = [];
            if($collection->getSize() > 0){
                $data = $collection->getLastItem()->getData();
                if(isset($data['image']) && $data['image'] != ''){
                    $data["image"] = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $data["image"];

                    $data["thumbnail"] = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . $data["thumbnail"];
                }
            }
            $res = [
                "code" => 0,
                "message" => "get data success",
                "result" => [
                    "seller" => $data
                    ]
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

    public function getListSellers(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->_seller->getCollection();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }

        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $searchResults = [];
        foreach ($collection as $val) {
            $data = $val->getData();
            if(isset($data['image']) && $data['image'] != ''){
                $data["image"] = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $data["image"];

                $data["thumbnail"] = $this->_storeManager->getStore()->getBaseUrl(
                \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . $data["thumbnail"];
            }
            $searchResults[] = $data;
        }
        $res = [
                "code" => 0,
                "message" => "get data success",
                "result" => [
                    "seller_list" => $searchResults
                    ]
            ];
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }
    /**
     * get seller review
     * @param string $seller_id
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersReviews($seller_id)
    {
        $sellerreviews = $this->_objectManager->get("Lof\MarketPlace\Model\Review");
        $data = $sellerreviews->getCollection()->addFieldToFilter('seller_id',$seller_id)->getData();
        foreach ($data as &$value) {
            $value["reviewseller_id"] = (int)$value["reviewseller_id"];
            $value["type"]            = (int)$value["type"];
            $value["seller_id"]       = (int)$value["seller_id"];
            $value["customer_id"]     = (int)$value["customer_id"];
            $value["review_id"]       = (int)$value["review_id"];
            $value["product_id"]      = (int)$value["product_id"];
            $value["rating"]          = (int)$value["rating"];
            $value["order_id"]        = (int)$value["order_id"];
            $value["is_public"]       = (int)$value["is_public"];
            $value["status"]          = (int)$value["status"];
        }
        $res = [
            "code" => 0,
            "message" => "Get data success"
        ];
        $res["result"] = [
            "reviews" => $data
        ];
        return $res;
    }
    /**
     * get seller rating
     * @param string $seller_idgetSellersRating
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersRating($seller_id)
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
     * @inheritDoc
     */
    public function getSellersbyProductID($product_id)
    {
        $sellerrating = $this->_objectManager->get("Lof\MarketPlace\Model\Rating");
        $seller = $this->_objectManager->create ('Lof\MarketPlace\Model\SellerProduct')->load ($product_id, 'product_id' );
        if($seller->getData("seller_id")){
            $this->getById($seller->getData("seller_id"));
        }
    }

    /**
     * @inheritDoc
     */
    public function getSellersProducts($seller_id)
    {
         return $this->sellerProduct->getSellerProducts($seller_id);
    }
}