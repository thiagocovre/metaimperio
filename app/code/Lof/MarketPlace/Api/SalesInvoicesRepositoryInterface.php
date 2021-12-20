<?php
namespace Lof\MarketPlace\Api;


interface SalesInvoicesRepositoryInterface
{
    /**
     * GET seller invoice
     * @param int $customerId
     * @return string
     *@throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerInvoices($customerId);
    /**
     * GET seller invoice by id
     * @param int $InvoiceId
     * @param int $customerId
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getSellerInvoicesByID($InvoiceId,$customerId);
}