<?php
namespace Lof\MarketPlace\Api;


interface SellerTransactionsRepositoryInterface
{
    /**
     * GET seller amounttransactions
     * @return string
     */
    public function getSellerTransactions();
}