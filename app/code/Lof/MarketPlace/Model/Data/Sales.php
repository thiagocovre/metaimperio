<?php

namespace Lof\MarketPlace\Model\Data;

// use Lof\CouponCode\Api\Data\ConditionInterface;
use Lof\MarketPlace\Api\Data\SalesInterface;

/**
 * Class Rule
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @codeCoverageIgnore
 */
class Sales extends \Magento\Framework\Api\AbstractExtensibleObject implements SalesInterface
{
    const KEY_SELLER_ID = 'seller_id';
    const KEY_ORDER_ID = 'order_id';
 
    public function getSellerId(){
        return $this->_get(self::KEY_SELLER_ID);
    }
    public function setSellerId($sellerId){
        return $this->setData(self::KEY_SELLER_ID, $sellerId);
    }
    public function getOrderId(){
        return $this->_get(self::KEY_ORDER_ID);
    }
    public function setOrderId($order_id){
        return $this->setData(self::KEY_ORDER_ID, $contact_number);
    }
}
