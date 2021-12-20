<?php
/**
 * Neoretail E-comm
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to https://www.neoretail.com for more information.
 *
 * @category Neoretail
 * @package base
 *
 * @copyright Copyright (c) 2021 Neoretail E-comm. (https://www.neoretail.com)
 *
 * @author Neoretail E-comm <contato@neoretail.com>
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Neoretail_InstallmentsPreview',
    __DIR__
);
