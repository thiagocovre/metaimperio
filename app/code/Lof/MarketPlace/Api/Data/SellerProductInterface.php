<?php
namespace Lof\MarketPlace\Api\Data;

interface SellerProductInterface
{
    const SELLER_PRODUCT = 'seller_product';

    /**
     * Get seller_product
     * @return string|null
     */
    public function getSellerProduct();

    /**
     * Set seller_product
     * @param string $seller_product
     * @return string|null
     */
    public function setSellerProduct($product);

}