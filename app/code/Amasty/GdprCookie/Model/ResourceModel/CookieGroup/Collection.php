<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Model\ResourceModel\CookieGroup;

use Amasty\GdprCookie\Model\CookieGroup;
use Amasty\GdprCookie\Model\ResourceModel\CookieGroup as CookieGroupResource;
use Amasty\GdprCookie\Setup\Operation\CreateCookieGroupDescriptionTable;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * @method CookieGroup[] getItems()
 */
class Collection extends AbstractCollection
{
    /**
     * @var bool
     */
    private $isStoreSettingsJoined = false;

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function _construct()
    {
        $this->_init(CookieGroup::class, CookieGroupResource::class);
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }

    /**
     * Join specific store cookies' entity fields
     *
     * @see CreateCookieGroupDescriptionTable::createTable
     * @param int $storeId
     * @return Collection
     */
    public function joinStoreSettings(int $storeId)
    {
        if (!$this->isStoreSettingsJoined) {
            $this->getSelect()->joinLeft(
                ['store_settings' => $this->getTable(CreateCookieGroupDescriptionTable::TABLE_NAME)],
                "main_table.{$this->getIdFieldName()} = store_settings.group_id"
                . " AND store_settings.store_id = {$storeId}",
                [
                    'store_settings.name AS group_store_name',
                    'store_settings.description AS group_store_description'
                ]
            );
            $this->isStoreSettingsJoined = true;
        }

        return $this;
    }
}
