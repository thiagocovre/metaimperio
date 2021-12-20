<?php
namespace Lof\MarketPlace\Api;


interface SellersRepositoryInterface
{
    /**
     * Get seller by Customer ID.
     * @param int $customerId
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If customer with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getCurrentSellers($customerId);
    /**
     * Save Profile
     * @param \Lof\MarketPlace\Api\Data\SellerInterface $seller
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     */
    public function saveProfile(\Lof\MarketPlace\Api\Data\SellerInterface $seller);
	
	/**
     * Save Profile
     * @param \Lof\MarketPlace\Api\Data\SellerInterface $seller
     * @param int $customerId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     */
    public function saveSeller(\Lof\MarketPlace\Api\Data\SellerInterface $seller,$customerId);
    /**
     * create new seller
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @param  mixed $data
     * @param  string $password
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided email is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Exception
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function registerNewSeller(\Magento\Customer\Api\Data\CustomerInterface $customer, $data, $password = null);
}