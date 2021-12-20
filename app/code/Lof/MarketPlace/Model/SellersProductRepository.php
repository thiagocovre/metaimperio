<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Lof\MarketPlace\Model;


class SellersProductRepository extends \Magento\Catalog\Model\ProductRepository
{
    public function SaveSellerProduct(\Magento\Catalog\Api\Data\ProductInterface $product, $saveOptions = false)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create("Lof\MarketPlace\Helper\Data");
        $check_auth = $helper->checkAuth();
        $res = Config::RES_RESULT;
        if($product){
            if ($check_auth) {
                $data = $product->getData();
                $seller_id = $helper->getAPISellerID($check_auth);
                if(isset($data["seller_id"]) && ($seller_id == $product->getSellerId())){
                    $this->save($product, false);
                    $res = [ "code" => 0, "message" => "Save data success"];
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($res, JSON_PRETTY_PRINT);
    }

}
