<?php

namespace Lof\MarketPlace\Api\Data;

interface SellerMessageInterface  extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const CONTENT = 'content';
    const STATUS = 'status';
    const MESSAGE_ID = 'message_id';
    const RECEIVER_NAME = 'receiver_name';
    const RECEIVER_EMAIL = 'receiver_email';

    /**
     * get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return string|null
     */
    public function setContent($content);

    /**
     * get shop_title
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return string|null
     */
    public function setStatus($status);

    /**
     * get message_id
     * @return string|null
     */
    public function getMessageId();

    /**
     * Set status
     * @param string $message_id
     * @return string|null
     */
    public function setMessageId($message_id);

    /**
     * get receiver name
     * @return string|null
     */
    public function getReceiverName();

    /**
     * Set status
     * @param string $receiver_name
     * @return string|null
     */
    public function setReceiverName($receiver_name);

    /**
     * get receiver email
     * @return string|null
     */
    public function getReceiverEmail();

    /**
     * Set receiver email
     * @param string $receiver_email
     * @return string|null
     */
    public function setReceiverEmail($receiver_email);
}