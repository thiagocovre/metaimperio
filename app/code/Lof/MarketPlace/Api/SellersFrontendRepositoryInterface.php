<?php


namespace Lof\MarketPlace\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SellersFrontendRepositoryInterface
{

    /**
     * Get seller by seller id
     * @param string $seller_id
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($seller_id);

    /**
     * get seller list with SearchCriteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Lof\MarketPlace\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getListSellers(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * get seller product
     * @param string $seller_id
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersProducts($seller_id);

    /**
     * get seller review
     * @param string $seller_id
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersReviews($seller_id);

    /**
     * get seller rating
     * @param string $seller_idgetSellersRating
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersRating($seller_id);

    /**
     * get seller by product id
     * @param string $product_id
     * @return string|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellersbyProductID($product_id);
}
