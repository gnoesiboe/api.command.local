<?php

namespace Gn\Api;

use Gn\Api\Domain\Permission\Permission;
use Gn\Api\Domain\Permission\PermissionIdentifier;

/**
 * RouteInterface
 */
interface RouteInterface
{

    /**
     * @return string[]
     */
    public function getFirewallAdapterKeys();

    /**
     * @return PermissionIdentifier[]
     */
    public function getRequiredPermissionsIdentifiers();

    /**
     * @return Command
     */
    public function getControllerClassName();
}
