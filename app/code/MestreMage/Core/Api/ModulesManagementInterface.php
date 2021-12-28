<?php
declare(strict_types=1);

namespace MestreMage\Core\Api;

interface ModulesManagementInterface
{

    /**
     * GET for modules api
     * @param string $param
     * @return string
     */
    public function getModules($param);
}

