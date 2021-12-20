<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Plugin\Response;

use Amasty\GdprCookie\Model\ConfigProvider;
use Amasty\GdprCookie\Model\CookieManager;
use Amasty\GdprCookie\Model\CookiePolicy;
use Amasty\GdprCookie\Model\Repository\CookieGroupsRepository;
use Amasty\GdprCookie\Model\Repository\CookieRepository;
use Amasty\GdprCookie\Model\ResourceModel\CookieGroupLink\Collection as LinkCollection;

class Http
{
    /**
     * @var \Amasty\GdprCookie\Model\ConfigProvider
     */
    private $configProvider;

    /**
     * @var \Amasty\GdprCookie\Model\CookieManager
     */
    private $cookieManager;

    /**
     * @var LinkCollection
     */
    private $linkCollection;

    /**
     * @var CookieRepository
     */
    private $cookieRepository;

    /**
     * @var CookieGroupsRepository
     */
    private $groupsRepository;

    /**
     * @var CookiePolicy
     */
    private $cookiePolicy;

    public function __construct(
        ConfigProvider $configProvider,
        CookieManager $cookieManager,
        LinkCollection $linkCollection,
        CookieRepository $cookieRepository,
        CookieGroupsRepository $groupsRepository,
        CookiePolicy $cookiePolicy
    ) {
        $this->configProvider = $configProvider;
        $this->cookieManager = $cookieManager;
        $this->linkCollection = $linkCollection;
        $this->cookieRepository = $cookieRepository;
        $this->groupsRepository = $groupsRepository;
        $this->cookiePolicy = $cookiePolicy;
    }

    /**
     * @param \Magento\Framework\App\Response\Http $subject
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSendResponse(\Magento\Framework\App\Response\Http $subject)
    {
        $allowedGroups = $this->cookieManager->getAllowCookies();

        if ($this->cookiePolicy->isCookiePolicyAllowed()
            && $allowedGroups
        ) {
            if ($allowedGroups !== CookieManager::ALLOWED_ALL && $allowedGroups !== CookieManager::ALLOWED_NONE) {
                $allowedGroups = explode(',', $allowedGroups);
                $allGroups = $this->groupsRepository->getAllGroups();
                $selectedGroups = [];

                foreach ($allGroups as $groupId => $group) {
                    if (!in_array($groupId, $allowedGroups)) {
                        array_push($selectedGroups, $groupId);
                    }
                }
                $rejectedCookies = [];

                foreach ($selectedGroups as $group) {
                    $cookies = $this->linkCollection->getCookiesByGroup($group);

                    foreach ($cookies as $cookie) {
                        array_push(
                            $rejectedCookies,
                            $this->cookieRepository->getById($cookie->getData('cookie_id'))->getName()
                        );
                    }
                }
                $this->cookieManager->deleteCookies($rejectedCookies);
            } elseif ($allowedGroups === CookieManager::ALLOWED_NONE) {
                $this->cookieManager->deleteCookies($this->cookieRepository->getAllCookieNames());
            }
        }
    }
}
