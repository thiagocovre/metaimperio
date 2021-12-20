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
namespace Lofmp\SplitCart\Plugin;

use Lofmp\SplitCart\Helper\ConfigData;

/**
 * Class GetItems
 * @package Lofmp\SplitCart\Plugin
 */
class GetItems {

    private $moduleConfig;

    /**
     * GetItems constructor.
     * @param ConfigData $configData
     */
    public function __construct(ConfigData $configData)
    {
        $this->moduleConfig = $configData;
    }

    /**
     * @param \Magento\Checkout\Block\Cart\Grid $subject
     * @param $result
     * @return mixed
     */
    public function afterGetItems(\Magento\Checkout\Block\Cart\Grid $subject, $result){
        if($this->moduleConfig->isEnabled()) {
            $modifiedResult = [];
            foreach ($result as $item) {
                $sellerId = $item->getSellerId();
                $modifiedResult[$sellerId][] = $item;
            }
        }

        return $result;
    }
}