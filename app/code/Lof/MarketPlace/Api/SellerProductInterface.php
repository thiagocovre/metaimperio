<?php
namespace Lof\MarketPlace\Api;

interface SellerProductInterface
{
    /**
     * assign product.
     * @param int $productId
     * @param int $storeId
     * @param int $customerId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function assignProduct($productId, $storeId, $customerId);
    /**
     *@param int $productId
     *@param int $sellerId
     *@param string $commission
     *@return mixed
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function setCommissionForSpecialProduct($productId, $commission,$sellerId);
    /**
     * Create product
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param int $customerId
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function createProduct(\Magento\Catalog\Api\Data\ProductInterface $product, $customerId);

}