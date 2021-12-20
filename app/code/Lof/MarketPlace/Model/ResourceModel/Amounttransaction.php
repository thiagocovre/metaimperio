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
namespace Lof\MarketPlace\Model\ResourceModel;

use Magento\Framework\DataObject\IdentityInterface;

/**
 * Amounttransaction Model
 */
class Amounttransaction extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb 
{
	 /**
     * Define amounttransactio
     */
    protected function _construct() {
        $this->_init ( 'lof_marketplace_amount_transaction', 'transaction_id' );
    }
}