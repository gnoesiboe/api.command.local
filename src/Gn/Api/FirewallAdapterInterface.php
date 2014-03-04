<?php

namespace Gn\Api;

/**
 * FirewallAdapterInterface
 */
interface FirewallAdapterInterface
{

    /**
     * @param Request $request
     * @return TokenInterface
     */
    public function authenticate(Request $request);

    /**
     * @param TokenInterface $token
     * @param Route $route
     */
    public function authorize(TokenInterface $token, Route $route);

    /**
     * @return array
     */
    public function getRequiredHeaders();
}
