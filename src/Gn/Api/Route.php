<?php

namespace Gn\Api;

use Gn\Api\Domain\Permission\PermissionIdentifier;
use Symfony\Component\Routing\Route as BaseRoute;

/**
 * Route class
 */
class Route extends BaseRoute implements RouteInterface
{

    /**
     * @var FirewallInterface[]
     */
    protected $firewallAdapterKeys = null;

    /**
     * @var PermissionIdentifier[]
     */
    protected $requiredPermissions = null;

    /**
     * @var Command
     */
    protected $controllerClassName = null;

    /**
     * @var RepresentationResolverInterface
     */
    protected $representationResolverClassName = null;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var string
     */
    protected $description = null;

    /**
     * @param string $path
     * @param array $methods
     * @param array $controllerClassName
     * @param array $firewallAdapterKeys
     * @param array $requiredPermissions
     */
    public function __construct(
        $path,
        array $methods,
        $controllerClassName,
        array $firewallAdapterKeys = array(),
        array $requiredPermissions = array()
    ) {
        parent::__construct($path);

        $this->setMethods($methods);

        $this
            ->setControllerClassName($controllerClassName)
            ->setFirewallAdapterKeys($firewallAdapterKeys)
            ->setRequiredPermissions($requiredPermissions)
        ;
    }

    /**
     * @param string[] $firewallAdapterKeys
     * @return Route
     */
    protected function setFirewallAdapterKeys(array $firewallAdapterKeys)
    {
        $this->firewallAdapterKeys = array();

        foreach ($firewallAdapterKeys as $firewallAdapterKey) {
            $this->setFirewallAdapterKey($firewallAdapterKey);
        }

        return $this;
    }

    /**
     * @param string $firewallAdapterKey
     * @return Route
     */
    protected function setFirewallAdapterKey($firewallAdapterKey)
    {
        $this->validateFirewallAdapterKey($firewallAdapterKey);
        $this->firewallAdapterKeys[] = $firewallAdapterKey;

        return $this;
    }

    /**
     * @param string $firewallAdapterKey
     * @throws \UnexpectedValueException
     */
    protected function validateFirewallAdapterKey($firewallAdapterKey)
    {
        if (is_string($firewallAdapterKey) === false) {
            throw new \UnexpectedValueException('firewallAdapterKey should be of type string');
        }
    }

    /**
     * @return string[]
     */
    public function getFirewallAdapterKeys()
    {
        return $this->firewallAdapterKeys;
    }

    /**
     * @param PermissionIdentifier[] $permissionsIdentifiers
     * @return Route
     */
    protected function setRequiredPermissions(array $permissionsIdentifiers)
    {
        $this->requiredPermissions = array();

        foreach ($permissionsIdentifiers as $permission) {
            $this->setRequiredPermissionIdentifiers($permission);
        }

        return $this;
    }

    /**
     * @param PermissionIdentifier $permission
     * @return Route
     */
    protected function setRequiredPermissionIdentifiers(PermissionIdentifier $permission)
    {
        $this->requiredPermissions[] = $permission;

        return $this;
    }

    /**
     * @return PermissionIdentifier[]
     */
    public function getRequiredPermissionsIdentifiers()
    {
        return $this->requiredPermissions;
    }

    /**
     * @param string $controllerClassName
     * @return Route
     *
     * @throws \UnexpectedValueException
     */
    protected function setControllerClassName($controllerClassName)
    {
        if (is_string($controllerClassName) === false) {
            throw new \UnexpectedValueException('Controller Class name should be of type string');
        }

        $this->controllerClassName = $controllerClassName;

        return $this;
    }

    /**
     * @return Command
     */
    public function getControllerClassName()
    {
        return $this->controllerClassName;
    }
}
