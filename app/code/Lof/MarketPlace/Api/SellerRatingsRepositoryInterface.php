<?php
namespace Lof\MarketPlace\Api;


interface SellerRatingsRepositoryInterface
{
    /**
     * GET seller ratings
     * @param int $seller_id
     * @return mixed
     */
    public function getSellerRatings($seller_id);
    /**
     * GET seller rating by id
     * @param int $id
     * @return mixed
     */
    public function getSellerRatingsByID($id);
}