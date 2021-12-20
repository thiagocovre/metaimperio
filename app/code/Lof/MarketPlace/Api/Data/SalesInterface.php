<?php

namespace Lof\MarketPlace\Api\Data;

interface SalesInterface  extends \Magento\Framework\Api\ExtensibleDataInterface
{
    const SELLER_ID = 'seller_id';
    const ORDER_ID = 'order_id';

    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     * @param string $seller_id
     * @return \Lof\CouponCode\Api\Data\SellerInterface
     */
    public function setSellerId($sellerId);

    /**
     * get order_id
     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id
     * @param string $order_id
     * @return string|null
     */
    public function setOrderId($order_id);
}
