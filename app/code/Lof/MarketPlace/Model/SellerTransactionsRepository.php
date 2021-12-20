<?php
namespace Lof\MarketPlace\Model;
use Lof\MarketPlace\Api\SellerTransactionsRepositoryInterface;
use Magento\Authorization\Model\CompositeUserContext;
use Lof\MarketPlace\Model\AmounttransactionFactory;

class SellerTransactionsRepository implements SellerTransactionsRepositoryInterface
{
    protected $userContext;
    protected $sellerFactory;
    protected $amountTransactionFactory;
    public function __construct(CompositeUserContext $userContext,
                                SellerFactory $sellerFactory,
                                 AmounttransactionFactory $amountTransactionFactory)
    {
        $this->userContext = $userContext;
        $this->sellerFactory = $sellerFactory;
        $this->amountTransactionFactory = $amountTransactionFactory;
    }

    /**
     * GET seller amounttransactions
     * @return string
     */
    public function getSellerTransactions(){
        $customerId = $this->userContext->getUserId();
        $seller = $this->sellerFactory->create()->getCollection()->addFieldToFilter('customer_id', $customerId);
        $sellerId = $seller->getData()[0]['seller_id'];
            $res = [
                "code" => 405,
                "message" => "Get data failed"
            ];
                $data = $this->amountTransactionFactory->create()->getCollection()->addFieldToFilter('seller_id',$sellerId)->getData();
                $res = [
                    "code" => 0,
                    "message" => "Get data success",
                    "amounttransaction" => $data
                ];
            return $res;
    }
}