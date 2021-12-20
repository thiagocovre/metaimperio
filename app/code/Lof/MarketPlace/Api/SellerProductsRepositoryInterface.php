<?php
namespace Lof\MarketPlace\Api;


interface SellerProductsRepositoryInterface
{
    /**
     * GET seller product list
     * @param string $seller_id - seller id
     * @return string
     */
    public function getSellerProducts($seller_id);

    /**
     * GET seller product by id
     * @param string $id - seller id
     * @return string
     */
    public function getListSellersProduct($id);

}