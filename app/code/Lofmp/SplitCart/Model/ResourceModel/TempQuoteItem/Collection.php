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
 * @package    Lofmp_SplitCart
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem;

/**
 * Class Collection
 * @package Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected function _construct()
    {
        $this->_setIdFieldName('entity_id');
        $this->_init('Lofmp\SplitCart\Model\TempQuoteItem', 'Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem');
    }
}
