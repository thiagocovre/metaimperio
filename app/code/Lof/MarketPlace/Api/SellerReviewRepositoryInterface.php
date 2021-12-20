<?php
namespace Lof\MarketPlace\Api;


interface SellerReviewRepositoryInterface
{
    /**
     * GET seller review
     * @return string
     */
    public function getSellerReviews();
    /**
     * GET seller review by id
     * @param string $id
     * @return string
     */
    public function getSellerReviewsByID($id);
}