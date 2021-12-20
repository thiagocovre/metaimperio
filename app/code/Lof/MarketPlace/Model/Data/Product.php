<?php

namespace Lof\MarketPlace\Model\Data;

use Lof\MarketPlace\Api\Data\SellerProductInterface;

/**
 * Class Rule
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @codeCoverageIgnore
 */
class Product extends \Magento\Framework\Api\AbstractExtensibleObject implements SellerProductInterface
{
    const KEY_SELLER_PRODUCT = 'seller_product';

    public function getSellerProduct(){
        return $this->_get(self::KEY_SELLER_PRODUCT);
    }
    public function setSellerProduct($seller_product){
        return $this->setData(self::KEY_SELLER_PRODUCT, $seller_product);
    }

}
