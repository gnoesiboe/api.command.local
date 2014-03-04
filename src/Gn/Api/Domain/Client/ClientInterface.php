<?php

namespace Gn\Api\Domain\Client;

use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Api\Domain\Permission\PermissionInterface;

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
     * @param PermissionInterface $permission
     *
     * @return ClientInterface
     */
    public function addPermission(PermissionInterface $permission);

    /**
     * @param PermissionIdentifier $permission
     * @return bool
     */
    public function hasPermission(PermissionIdentifier $permission);
}
