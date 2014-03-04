<?php

namespace Gn\Api;

/**
 * Firewall class
 */
class Firewall implements FirewallInterface
{

    /**
     * @var FirewallAdapterInterface[]
     */
    protected $adapters = array();

    /**
     * @var TokenInterface[]
     */
    protected $tokens = array();

    /**
     * @var bool
     */
    protected $passed = null;

    /**
     * @param string $adapterKey
     * @param FirewallAdapterInterface $firewallAdapter
     *
     * @return Firewall
     */
    public function registerAdapter($adapterKey, FirewallAdapterInterface $firewallAdapter)
    {
        $this->validateAdapterKey($adapterKey);
        $this->adapters[$adapterKey] = $firewallAdapter;

        return $this;
    }

    /**
     * @param string $key
     * @throws \UnexpectedValueException
     */
    protected function validateAdapterKey($key)
    {
        if (is_string($key) === false) {
            throw new \UnexpectedValueException('Key should be of type String');
        }
    }

    /**
     * @param string $key
     * @return FirewallAdapterInterface
     */
    public function getAdapter($key)
    {
        $this->validateHasAdapter($key);

        return $this->adapters[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasAdapter($key)
    {
        return array_key_exists($key, $this->adapters) === true;
    }

    /**
     * @param string $key
     * @throws \UnexpectedValueException
     */
    protected function validateHasAdapter($key)
    {
        if ($this->hasAdapter($key) === false) {
            throw new \UnexpectedValueException(sprintf('No adapter registered with key: \'%s\'', $key));
        }
    }

    /**
     * @param Route $route
     * @param Request $request
     */
    public function validate(Route $route, Request $request)
    {
        $this->validateIsNotPassed();

        foreach ($route->getFirewallAdapterKeys() as $firewallAdapterKey) {
            /** @var string $firewallAdapterKey */

            $adapter = $this->getAdapter($firewallAdapterKey);
            $token = $adapter->authenticate($request);

            $adapter->authorize($token, $route);

            $this->tokens[$firewallAdapterKey] = $token;
        }

        $this->passed = true;
    }

    /**
     * @throws \UnexpectedValueException
     */
    protected function validateIsNotPassed()
    {
        if (is_bool($this->passed) === true) {
            throw new \UnexpectedValueException('Firewall validation process can only occur once');
        }
    }

    /**
     * @param $key
     * @return TokenInterface
     */
    public function getToken($key)
    {
        $this->validateHasToken($key);

        return $this->tokens[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasToken($key)
    {
        return array_key_exists($key, $this->tokens);
    }

    /**
     * @param string $key
     * @throws \UnexpectedValueException
     */
    protected function validateHasToken($key)
    {
        if ($this->hasToken($key) === false) {
            throw new \UnexpectedValueException(sprintf('Firewall has no token with key: \'%s\'', $key));
        }
    }
}
