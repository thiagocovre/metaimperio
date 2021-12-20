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
use Magento\Checkout\Model\Cart as CustomerCart;

/**
 * Class SelectSellerNotice
 * @package Lofmp\SplitCart\Plugin
 */
class SelectSellerNotice {

    protected $messageManager;

    private $moduleConfig;

    private $cart;

    /**
     * SelectSellerNotice constructor.
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param ConfigData $configData
     * @param CustomerCart $cart
     */
    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        ConfigData $configData,
        CustomerCart $cart)
    {
        $this->messageManager = $messageManager;
        $this->moduleConfig = $configData;
        $this->cart = $cart;
    }

    /**
     * @param \Magento\Checkout\Controller\Cart\Index $subject
     * @param $result
     * @return mixed
     */
    public function afterExecute(\Magento\Checkout\Controller\Cart\Index $subject, $result){
        if($this->moduleConfig->isEnabled()){
            $quote = $this->cart->getQuote();
            $items = $quote->getAllItems();
            if(count($items)){
                $this->messageManager->addNotice("Please select at least one product to checkout");
            }
        }

        return $result;
    }
}