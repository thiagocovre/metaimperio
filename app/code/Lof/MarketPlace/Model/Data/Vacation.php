<?php

namespace Lof\MarketPlace\Model\Data;

use Lof\MarketPlace\Api\Data\SellerVacationInterface;

class Vacation extends \Magento\Framework\Api\AbstractExtensibleObject implements SellerVacationInterface
{
    const KEY_VACATION_ID = 'vacation_id';
    const KEY_STATUS = 'status';
    const KEY_VACATION_MESSAGE = 'vacation_message';
    const KEY_FROM_DATE = 'from_date';
    const KEY_TO_DATE = 'to_date';
    const KEY_TEXT_ADD_CART = 'text_add_cart';
    const KEY_SELLER_ID = 'seller_id';
    const KEY_CREATED_AT = 'created_at';
    const KEY_UPDATED_AT = 'updated_at';

    public function getSellerId()
    {
        return $this->_get(self::KEY_SELLER_ID);
    }
    public function setSellerId($seller_id)
    {
        return $this->setData(self::KEY_SELLER_ID, $seller_id);
    }
    public function getCreatedAt()
    {
        return $this->_get(self::KEY_CREATED_AT);
    }
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::KEY_CREATED_AT, $created_at);
    }
    public function getUpdatedAt()
    {
        return $this->_get(self::KEY_UPDATED_AT);
    }
    public function setUpdatedAt($updated_at)
    {
        return $this->setData(self::KEY_UPDATED_AT, $updated_at);
    }
    public function getVacationId(){
        return $this->_get(self::KEY_VACATION_ID);
    }
    public function setVacationId($vacation_id){
        return $this->setData(self::KEY_VACATION_ID, $vacation_id);
    }
    public function getStatus(){
        return $this->_get(self::KEY_STATUS);
    }
    public function setStatus($status){
        return $this->setData(self::KEY_STATUS, $status);
    }
    public function getVacationMessage(){
        return $this->_get(self::KEY_VACATION_MESSAGE);
    }
    public function setVacationMessage($vacation_message){
        return $this->setData(self::KEY_VACATION_MESSAGE, $vacation_message);
    }
    public function getFromDate(){
        return $this->_get(self::KEY_FROM_DATE);
    }
    public function setFromDate($from_date){
        return $this->setData(self::KEY_FROM_DATE, $from_date);
    }
    public function getToDate(){
        return $this->_get(self::KEY_TO_DATE);
    }
    public function setToDate($to_date){
        return $this->setData(self::KEY_TO_DATE, $to_date);
    }
    public function getTextAddCart(){
        return $this->_get(self::KEY_TEXT_ADD_CART);
    }
    public function setTextAddCart($text_add_cart){
        return $this->setData(self::KEY_TEXT_ADD_CART, $text_add_cart);
    }

}
