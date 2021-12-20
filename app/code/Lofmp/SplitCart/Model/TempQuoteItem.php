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
namespace Lofmp\SplitCart\Model;

/**
 * Class TempQuoteItem
 * @package Lofmp\SplitCart\Model
 */
class TempQuoteItem extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Lofmp\SplitCart\Model\ResourceModel\TempQuoteItem');
    }
}
