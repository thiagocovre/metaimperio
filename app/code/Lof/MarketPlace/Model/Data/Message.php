<?php

namespace Lof\MarketPlace\Model\Data;

use Lof\MarketPlace\Api\Data\SellerMessageInterface;

/**
 * Class Rule
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @codeCoverageIgnore
 */
class Message extends \Magento\Framework\Api\AbstractExtensibleObject implements SellerMessageInterface
{
    const KEY_CONTENT = 'content';
    const KEY_STATUS = 'status';
    const KEY_MESSAGE_ID = 'message_id';
    const KEY_RECEIVER_NAME = 'receiver_name';
    const KEY_RECEIVER_EMAIL = 'receiver_email';
 
    public function getContent(){
        return $this->_get(self::KEY_CONTENT);
    }
    public function setContent($content){
        return $this->setData(self::KEY_CONTENT, $content);
    }

    public function getStatus(){
        return $this->_get(self::KEY_STATUS);
    }
    public function setStatus($status){
        return $this->setData(self::KEY_STATUS, $status);
    }

    public function getMessageId(){
        return $this->_get(self::KEY_MESSAGE_ID);
    }
    public function setMessageId($message_id ){
        return $this->setData(self::KEY_MESSAGE_ID, $message_id );
    }

    public function getReceiverName(){
        return $this->_get(self::KEY_RECEIVER_NAME);
    }
    public function setReceiverName($receiver_name ){
        return $this->setData(self::KEY_RECEIVER_NAME, $receiver_name );
    }

    public function getReceiverEmail(){
        return $this->_get(self::KEY_RECEIVER_EMAIL);
    }
    public function setReceiverEmail($receiver_email ){
        return $this->setData(self::KEY_RECEIVER_EMAIL, $receiver_email );
    }

}
