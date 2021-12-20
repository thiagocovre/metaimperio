<?php
namespace Lof\MarketPlace\Api;


interface SellerVacationRepositoryInterface
{
    /**
     * GET seller vacation
     * @param int $customerId
     * @return string
     */
    public function getSellerVacation($customerId);

    /**
     * PUT Vacation
     * @param \Lof\MarketPlace\Api\Data\SellerVacationInterface $vacation
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Lof\MarketPlace\Api\Data\SellerVacationInterface
     */
    public function putSellerVacation(\Lof\MarketPlace\Api\Data\SellerVacationInterface $vacation);

}