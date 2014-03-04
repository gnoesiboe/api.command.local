<?php

namespace Gn\Api;

use Gn\Api\Exception\UnauthorizedException;

/**
 * FirewallInterface
 */
interface FirewallInterface
{

    /**
     * @param string $adapterKey
     * @param FirewallAdapterInterface $firewallAdapter
     *
     * @return FirewallInterface
     */
    public function registerAdapter($adapterKey, FirewallAdapterInterface $firewallAdapter);

    /**
     * @param Route $route
     * @param Request $request
     *
     * @throws UnauthorizedException
     */
    public function validate(Route $route, Request $request);

    /**
     * @param string $key
     * @return TokenInterface
     *
     * @throws \UnexpectedValueException
     */
    public function getToken($key);

    /**
     * @param string $key
     * @return bool
     */
    public function hasToken($key);

    /**
     * @param string $key
     * @return FirewallAdapterInterface
     */
    public function getAdapter($key);

    /**
     * @param string $key
     * @return bool
     */
    public function hasAdapter($key);
}
