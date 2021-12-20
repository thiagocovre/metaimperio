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

interface ProductInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ENTITY_ID          = 'entity_id';
    const TYPE_ID            = 'type_id';
    const SKU                = 'sku';
    const QTY                = 'qty';
    const HAS_OPTIONS        = 'has_options';
    const REQUIRED_OPTIONS   = 'required_options';
    const CREATED_AT         = 'created_at';
    const UPDATED_AT         = 'updated_at';
    const SELLER_ID          = 'seller_id';
    const APPROVAL           = 'approval';
    const NAME               = 'name';
    const PRICE              = 'price';
    const ATTRIBUTE_SET_ID   = 'attribute_set_id';

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Set ID
     *
     * @param int $id

     */
    public function setId($id);
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getQty();

    /**
     * Set qty
     *
     * @param int $qty

     */
    public function setQty($qty);
    /**
     * Get type_id
     *
     * @return int|null
     */
    public function getTypeId();

    /**
     * Set type_id
     *
     * @param int $type_id

     */
    public function setTypeId($type_id);
    /**
     * Get SKU
     *
     * @return string|null
     */
    public function getSku();

    /**
     * Set sku
     * @param string $sku
     * @return string|null
     */
    public function setSku($sku);
    /**
     * Get has_options
     *
     * @return string|null
     */
    public function getHasOptions();

    /**
     * Set has_options
     *
     * @param int $has_options
     * @return string|null
     */
    public function setHasOptions($has_options);
    /**
     * Get required_options
     *
     * @return string|null
     */
    public function getRequiredOptions();

    /**
     * Set required_options
     *
     * @param int $required_options
     * @return string|null
     */
    public function setRequiredOptions($required_options);

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     *
     * @param string $created_at
     * @return string|null
     */
    public function setCreatedAt($created_at);
    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     *
     * @param string $updated_at
     * @return string|null
     */
    public function setUpdatedAt($updated_at);
    /**
     * Get seller_id
     *
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
     * Get approval
     *
     * @return string|null
     */
    public function getApproval();

    /**
     * Set approval
     *
     * @param string $approval
     * @return string|null
     */
    public function setApproval($approval);
    /**
     * Get name
     *
     * @return string|null
     */
    public function getName();
    /**
     * Set name
     * @param string $name
     * @return string|null
     */
    public function setName($name);

    /**
     * Set price
     * @param string $price
     * @return string|null
     */
    public function setPrice($price);
    /**
     * Get price
     *
     * @return string|null
     */
    public function getPrice();
    /**
         * Set attribute_set_id
         *
         * @param string $attribute_set_id
         * @return string|null
         */
        public function setAttributeSetId($attribute_set_id);
        /**
         * Get price
         *
         * @return string|null
         */
        public function getAttributeSetId();




}