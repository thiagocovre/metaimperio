<?php
/**
 * @author Amasty Team
 * @copyright Copyright (c) 2020 Amasty (https://www.amasty.com)
 * @package Amasty_GdprCookie
 */


namespace Amasty\GdprCookie\Api\Data;

interface CookieInterface
{
    /**#@+
     * Constants defined for keys of data array
     */
    const ID = 'id';

    const NAME = 'name';

    const DESCRIPTION = 'description';

    const LIFETIME = 'cookie_lifetime';

    /**#@-*/

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return \Amasty\GdprCookie\Api\Data\CookieInterface
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return \Amasty\GdprCookie\Api\Data\CookieInterface
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     *
     * @return \Amasty\GdprCookie\Api\Data\CookieInterface
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getLifetime();

    /**
     * @param string $description
     *
     * @return \Amasty\GdprCookie\Api\Data\CookieInterface
     */
    public function setLifetime($lifetime);
}
