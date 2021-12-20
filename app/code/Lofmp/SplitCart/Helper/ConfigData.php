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
 * @package    Lofmp_FeaturedProducts
 * @copyright  Copyright (c) 2018 Landofcoder (http://www.landofcoder.com/)
 * @license    http://www.landofcoder.com/LICENSE-1.0.html
 */
namespace Lofmp\SplitCart\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ConfigData
 * @package Lofmp\SplitCart\Helper
 */
class ConfigData extends AbstractHelper
{
    const PATH_GENERAL_SETTING = 'split_cart_config/general/';

    /**
     * @param Context $context
     */
    public function __construct(Context $context) {
        parent::__construct($context);
    }

    /**
     * @param $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfigValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param $field
     * @param null $storeId
     * @return mixed
     */
    public function getGeneralConfig($field, $storeId = null)
    {
        return $this->getConfigValue(self::PATH_GENERAL_SETTING . $field, $storeId);
    }

    /**
     * @return bool
     */
    public function isEnabled(){
        $status = $this->getGeneralConfig('enable');
        return $status == 0 ? false : true;
    }
}