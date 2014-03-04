<?php

namespace Gn\Api\Domain\Client;

use Gn\Api\Domain\Permission\PermissionIdentifier;

/**
 * ClientInterface
 */
interface ClientInterface
{

    /**
     * @return ClientKeyInterface
     */
    public function getKey();

    /**
     * @param PermissionIdentifier $permission
     * @return bool
     */
    public function hasPermission(PermissionIdentifier $permission);
}
