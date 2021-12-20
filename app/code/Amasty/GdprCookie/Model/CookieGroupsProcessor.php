<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Model;

use Amasty\GdprCookie\Api\Data\CookieGroupsInterface;
use Amasty\GdprCookie\Model\ResourceModel\Cookie;
use Amasty\GdprCookie\Model\ResourceModel\CookieGroup;

class CookieGroupsProcessor
{
    /**
     * @var Cookie\CollectionFactory
     */
    private $cookieCollectionFactory;

    /**
     * @var CookieGroup\CollectionFactory
     */
    private $cookieGroupCollectionFactory;

    /**
     * @var string[]
     */
    private $allowedCookieGroups;

    /**
     * @var array
     */
    private $cookieGroupDataCache = [];

    public function __construct(
        Cookie\CollectionFactory $cookieCollectionFactory,
        CookieGroup\CollectionFactory $cookieGroupCollectionFactory,
        CookieManager $cookieManager
    ) {
        $this->cookieCollectionFactory = $cookieCollectionFactory;
        $this->cookieGroupCollectionFactory = $cookieGroupCollectionFactory;
        $this->allowedCookieGroups = explode(',', $cookieManager->getAllowCookies());
    }

    /**
     * @param int $storeId
     * @return array
     */
    public function getAllGroups(int $storeId)
    {
        if (!isset($this->cookieGroupDataCache[$storeId])) {
            $groupData = [];
            $allCookiesAllowed = in_array('0', $this->allowedCookieGroups, true);
            $cookieCollection = $this->cookieCollectionFactory->create()
                ->addGroupsColumn()
                ->joinStoreSettings($storeId);
            $cookieGroupCollection = $this->cookieGroupCollectionFactory->create()->joinStoreSettings($storeId);

            foreach ($cookieGroupCollection as $cookieGroup) {
                if (!$cookieGroup->getIsEnabled()) {
                    continue;
                }

                $groupData[$cookieGroup->getId()] = [
                    'groupId' => $cookieGroup->getId(),
                    'isEssential' => $cookieGroup->getIsEssential(),
                    'name' => $cookieGroup->getGroupStoreName() ?? $cookieGroup->getName(),
                    'description' => $cookieGroup->getGroupStoreDescription() ?? $cookieGroup->getDescription(),
                    'checked' => $allCookiesAllowed || $this->isCookieGroupChecked($cookieGroup),
                    'cookies' => []
                ];
            }

            if ($groupData) {
                foreach ($cookieCollection as $cookie) {
                    if (isset($groupData[$cookie->getGroupId()])) {
                        $groupData[$cookie->getGroupId()]['cookies'][] = [
                            'name' => $cookie->getName(),
                            'description' => $cookie->getCookieStoreDescription() ?? $cookie->getDescription(),
                            'lifetime' => $cookie->getLifetime()
                        ];
                    }
                }
            }

            $this->cookieGroupDataCache[$storeId] = array_values($groupData);
        }

        return $this->cookieGroupDataCache[$storeId];
    }

    /**
     * @param CookieGroupsInterface $cookieGroup
     * @return bool
     */
    private function isCookieGroupChecked(CookieGroupsInterface $cookieGroup): bool
    {
        return in_array($cookieGroup->getId(), $this->allowedCookieGroups) || $cookieGroup->getIsEssential();
    }
}
