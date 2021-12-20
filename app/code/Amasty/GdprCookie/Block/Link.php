<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Block;

use Amasty\GdprCookie\Model\ConfigProvider;
use Amasty\GdprCookie\Model\CookiePolicy;
use Magento\Framework\App\DefaultPathInterface;
use Magento\Framework\View\Element\Template\Context;

class Link extends \Magento\Framework\View\Element\Html\Link\Current
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var CookiePolicy
     */
    private $cookiePolicy;

    public function __construct(
        Context $context,
        ConfigProvider $configProvider,
        DefaultPathInterface $defaultPath,
        CookiePolicy $cookiePolicy,
        array $data = []
    ) {
        parent::__construct($context, $defaultPath, $data);
        $this->configProvider = $configProvider;
        $this->cookiePolicy = $cookiePolicy;
    }

    /**
     * @return string
     */
    public function toHtml()
    {
        if (!$this->cookiePolicy->isCookiePolicyAllowed()) {
            return '';
        }

        return parent::toHtml();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        if (!$this->hasData('path')) {
            $this->setData('path', $this->configProvider->getCookieSettingsPage());
        }

        return $this->getData('path');
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return __('Cookie Settings');
    }
}
