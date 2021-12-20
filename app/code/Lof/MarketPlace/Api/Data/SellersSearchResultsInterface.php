<?php

namespace Lof\MarketPlace\Api\Data;

interface SellersSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get seller list.
     * @return \Lof\MarketPlace\Api\Data\SellerInterface[]
     */
    public function getItems();

    /**
     * Set seller list.
     * @param \Lof\MarketPlace\Api\Data\SellerInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
