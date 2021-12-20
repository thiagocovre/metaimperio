<?php
/**
 * Landofcoder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://www.landofcoder.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2017 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Api\Data;

interface AmountTransactionInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const TRANSACTION_ID     = 'transaction_id';
    const CUSTOMER_ID        = 'customer_id';
    const SELLER_ID          = 'seller_id ';
    const TYPE               = 'type';
    const AMOUNT             = 'amount';
    const BALANCE            = 'balance';
    const DESCRIPTION        = 'description';
    const ADDITIONAL_INFO    = 'additional_info';
    const CREATED_AT         = 'created_at';
    /**
     * Get transaction_id
     *
     * @return int|null
     */
    public function getTransactionId();

    /**
     * Set transaction_id
     * @param int $transaction_id
     * @return string|null
     */
    public function setTransactionId($transaction_id);
    /**
     * Get transaction_id
     * @return string|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     * @param int $customer_id
     * @return string|null
     */
    public function setCustomerId($customer_id);
    /**
     * Get seller_id
     * @return string|null
     */
    public function getSellerId();

    /**
     * Set seller_id
     *
     * @param int $seller_id
     * @return string|null
     */
    public function setSellerId($seller_id);
    /**
     * Get transaction_id
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return string|null
     */
    public function setType($type);
    /**
     * Get amount
     * @return string|null
     */
    public function getAmount();

    /**
     * Set amount
     * @param string $amount
     * @return string|null
     */
    public function setAmount($amount);
    /**
     * Get balance
     * @return string|null
     */
    public function getBalance();

    /**
     * Set balance
     * @param string $balance
     * @return string|null
     */
    public function setBalance($balance);
    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return string|null
     */
    public function setDescription($description);
    /**
     * Get additional_info
     * @return string|null
     */
    public function getAdditionalInfo();

    /**
     * Set additional_info
     * @param string $additional_info
     * @return string|null
     */
    public function setAdditionalInfo($additional_info);
    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return string|null
     */
    public function setCreatedAt($created_at);
}