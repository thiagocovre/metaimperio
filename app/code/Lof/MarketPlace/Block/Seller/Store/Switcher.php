<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * http://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_MarketPlace
 * @copyright  Copyright (c) 2016 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\MarketPlace\Block\Seller\Store;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Switcher extends \Magento\Backend\Block\Store\Switcher
{
    /**
     * Block template filename
     *
     * @var string
     */
    protected $_template = 'Lof_MarketPlace::store/switcher.phtml';
}
