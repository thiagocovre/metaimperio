<?php
namespace Lof\MarketPlace\Api;


interface UpdateStockRepositoryInterface
{

    /**
     * Update stock qty
     * @param mixed $product
     * @return string
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveSellerStock($product);

    /**
     * Update stock price
     * @param mixed $product
     * @return string
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function saveSellerProductPrice($product);
}