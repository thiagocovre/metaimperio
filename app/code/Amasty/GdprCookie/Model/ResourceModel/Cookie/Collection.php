<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Model\ResourceModel\Cookie;

use Amasty\GdprCookie\Model\Cookie;
use Amasty\GdprCookie\Model\ResourceModel\Cookie as CookieResource;
use Amasty\GdprCookie\Setup\Operation\CreateCookieDescriptionTable;
use Amasty\GdprCookie\Setup\Operation\CreateCookieGroupLinkTable;
use Amasty\GdprCookie\Setup\Operation\CreateCookieGroupsTable;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @method Cookie[] getItems()
 */
class Collection extends AbstractCollection
{
    /**
     * @var bool
     */
    private $isStoreSettingsJoined = false;

    /**
     * @var bool
     */
    private $isGroupsColumnAdded = false;

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _construct()
    {
        $this->_init(Cookie::class, CookieResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }

    /**
     * Join specific store cookies' entity fields
     *
     * @see CreateCookieDescriptionTable::createTable
     * @param int $storeId
     * @return $this
     */
    public function joinStoreSettings(int $storeId)
    {
        if (!$this->isStoreSettingsJoined) {
            $this->getSelect()->joinLeft(
                ['store_settings' => $this->getTable(CreateCookieDescriptionTable::TABLE_NAME)],
                "main_table.{$this->getIdFieldName()} = store_settings.cookie_id"
                . " AND store_settings.store_id = {$storeId}",
                ['store_settings.description AS cookie_store_description']
            );
            $this->isStoreSettingsJoined = true;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function addGroupsColumn()
    {
        if (!$this->isGroupsColumnAdded) {
            $this->getSelect()->joinLeft(
                ['link' => $this->getTable(CreateCookieGroupLinkTable::TABLE_NAME)],
                'main_table.id = link.cookie_id',
                'link.group_id'
            )->joinLeft(
                ['groups' => $this->getTable(CreateCookieGroupsTable::TABLE_NAME)],
                'link.group_id = groups.id',
                ['group' => 'COALESCE(groups.name, "None")']
            );
            $this->isGroupsColumnAdded = true;
        }

        return $this;
    }
}
