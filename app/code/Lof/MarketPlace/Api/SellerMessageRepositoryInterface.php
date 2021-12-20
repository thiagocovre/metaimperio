<?php
namespace Lof\MarketPlace\Api;


interface SellerMessageRepositoryInterface
{
    /**
     * GET seller seller message
     * @param int $customerId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerMessages($customerId);

    /**
     * GET seller seller message
     * @param int $customerId
     * @param int $messageId
     * @return mixed
     */

    public function getSellermessageById($customerId, $messageId);

    /**
     * Save Profile
     * @param \Lof\MarketPlace\Api\Data\SellerMessageInterface $message
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Lof\MarketPlace\Api\Data\SellerMessageInterface
     */
    public function ReplyMessage(\Lof\MarketPlace\Api\Data\SellerMessageInterface $message);
}