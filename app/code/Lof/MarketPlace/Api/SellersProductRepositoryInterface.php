<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Lof\MarketPlace\Api;

/**
 * @api
 * @since 100.0.2
 */
interface SellersProductRepositoryInterface
{
    /**
     * Create product
     *
     * @param \Lof\MarketPlace\Api\Data\SellersProductInterface $product
     * @param bool $saveOptions
     * @return \Lof\MarketPlace\Api\Data\SellersProductInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Lof\MarketPlace\Api\Data\SellersProductInterface $product, $saveOptions = false);
}
