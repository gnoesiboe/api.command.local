<?php

namespace Gn\Api;

use App\RepresentationResolver\NewsitemRepresentationResolver;
use Gn\Api\Domain\Permission\PermissionIdentifier;

/**
 * RouteFactory
 *
 * @todo replace with DetailRoute::create() setups?
 */
class RouteFactory
{

    /**
     * @param string $entityName
     * @param array $methods
     * @param array $firewallAdapterKeys
     * @param array $requiredPermissions
     * @param int $version
     *
     * @return Route
     */
    public function generateIndexRoute($entityName, array $methods, array $firewallAdapterKeys, array $requiredPermissions = array(), $version = 1)
    {
        return new Route(
            $this->generateIndexUrl($entityName, $version),
            $this->prepareMethods($methods),
            $this->generateIndexControllerClassName($entityName),
            $firewallAdapterKeys,
            $requiredPermissions
        );
    }

    /**
     * @param string $entityName
     * @param array $methods
     * @param array $firewallAdapterKeys
     * @param array $requiredPermissions
     * @param int $version
     *
     * @return Route
     */
    public function generateDetailRoute($entityName, array $methods, array $firewallAdapterKeys, array $requiredPermissions = array(), $version = 1)
    {
        $route = new Route(
            $this->generateDetailUrl($entityName, $version),
            $this->prepareMethods($methods),
            $this->generateDetailControllerClassName($entityName),
            $firewallAdapterKeys,
            $requiredPermissions
        );

        $route->setRequirement('id', '\d+');

        return $route;
    }

    /**
     * @param array $methods
     * @return array
     */
    protected function prepareMethods(array $methods)
    {
        return array_merge(array('OPTIONS'), $methods);
    }

    /**
     * @param string $entityName
     * @param string $version
     *
     * @return string
     */
    protected function generateDetailUrl($entityName, $version)
    {
        return "/v$version/$entityName/{id}";
    }

    /**
     * @param string $entityName
     * @param string $version
     *
     * @return string
     */
    protected function generateIndexUrl($entityName, $version)
    {
        return "/v$version/$entityName";
    }

    /**
     * @param string $entity
     * @return string
     */
    protected function generateIndexActionClass($entity)
    {
        return strtr('App\Controller\%entity%\IndexController', array('%entity%' => ucfirst($entity)));
    }

    /**
     * @param string $entityName
     * @return string
     */
    protected function generateIndexControllerClassName($entityName)
    {
        return strtr('App\Controller\%entity%\IndexController', array('%entity%' => ucfirst($entityName)));
    }

    /**
     * @param string $entityName
     * @return string
     */
    protected function generateDetailControllerClassName($entityName)
    {
        return strtr('App\Controller\%entity%\DetailController', array('%entity%' => ucfirst($entityName)));
    }

    /**
     * @param string $entity
     * @return string
     */
    public function generateDetailIdentifier($entity)
    {
        return $entity . '_detail';
    }

    /**
     * @param string $entity
     * @return string
     */
    public function generateIndexIdentifier($entity)
    {
        return $entity . '_index';
    }

    /**
     * @param string $entity
     * @return string
     */
    public function generateCreateIdentifier($entity)
    {
        return $entity . '_create';
    }

    /**
     * @param string $entity
     * @return string
     */
    public function generateUpdateIdentifier($entity)
    {
        return $entity . '_update';
    }

    /**
     * @param string $entity
     * @return string
     */
    public function generateDeleteIdentifier($entity)
    {
        return $entity . '_delete';
    }
}
