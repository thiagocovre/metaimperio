<?php
namespace Lof\MarketPlace\Api;


interface SalesRepositoryInterface
{
    /**
     * GET seller order
     * @param int $customerId

     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function getSellerOrders($customerId);
    /**
     * GET seller order by id
     * @param int $id
     * @param int $customerId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
    */
    public function getSellerOrderById($id, $customerId);

    /**
     * GET order cancel
     * @param int $orderId
     * @param int $customerId
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function orderCancel($orderId, $customerId);

    /**
     * POST create Seller Order
     * @param int $orderId
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createSellerOrder($orderId,$customerId);
}