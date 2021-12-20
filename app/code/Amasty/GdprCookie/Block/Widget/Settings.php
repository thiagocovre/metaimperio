<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Block\Widget;

use Amasty\GdprCookie\Model\ConfigProvider;
use Amasty\GdprCookie\Model\CookieGroup;
use Amasty\GdprCookie\Model\CookieGroupLink;
use Amasty\GdprCookie\Model\CookieGroupsProcessor;
use Amasty\GdprCookie\Model\CookiePolicy;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Settings extends Template implements BlockInterface, IdentityInterface
{
    protected $_template = "widget/settings.phtml";

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var CookieGroupsProcessor
     */
    private $cookieGroupsProcessor;

    /**
     * @var CookiePolicy
     */
    private $cookiePolicy;

    public function __construct(
        ConfigProvider $configProvider,
        CookieGroupsProcessor $cookieGroupsProcessor,
        Template\Context $context,
        CookiePolicy $cookiePolicy,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
        $this->cookieGroupsProcessor = $cookieGroupsProcessor;
        $this->cookiePolicy = $cookiePolicy;
    }

    /**
     * @return array
     */
    public function getAllGroups()
    {
        $storeId = $this->_storeManager->getStore()->getId();

        return $this->cookieGroupsProcessor->getAllGroups($storeId);
    }

    public function isNeedToShow()
    {
        if (!$this->cookiePolicy->isCookiePolicyAllowed()) {
            return false;
        }

        return true;
    }

    public function getIdentities()
    {
        return [CookieGroupLink::CACHE_TAG, CookieGroup::CACHE_TAG];
    }

    public function getCacheLifetime()
    {
        return null;
    }

    public function getCacheTags()
    {
        return $this->getIdentities();
    }
}
