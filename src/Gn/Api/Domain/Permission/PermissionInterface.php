<?php

namespace Gn\Api\Domain\Permission;

/**
 * PermissionInterface
 */
interface PermissionInterface
{

    /**
     * @return PermissionIdentifier
     */
    public function getIdentifier();
}
