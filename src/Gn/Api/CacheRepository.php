<?php

namespace Gn\Api;

use Gn\Api\Domain\Client\ClientInterface;
use Gn\Api\Domain\Client\ClientKeyInterface;

/**
 * CacheRepository
 */
class CacheRepository implements CacheRepositoryInterface
{

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param ClientKeyInterface $key
     * @param mixed $default
     *
     * @return ClientInterface|mixed
     */
    public function getClient(ClientKeyInterface $key, $default = null)
    {
        $cacheEntry = $this->cache->get($this->generateClientCacheKey($key));

        if ($cacheEntry instanceof CacheEntryInterface) {
            return $cacheEntry->getValue();
        }

        return $default;
    }

    /**
     * @param ClientKeyInterface $key
     * @return string
     */
    protected function generateClientCacheKey(ClientKeyInterface $key)
    {
        return 'client_' . $key->getValue();
    }

    /**
     * @param ClientInterface $client
     */
    public function saveClient(ClientInterface $client)
    {
        $this->cache->set(
            $this->generateClientCacheKey($client->getKey()),
            new CacheEntry($client, 86400) //@todo move cache lifetime to parameters
        );
    }

    /**
     * @param ClientKeyInterface $key
     */
    public function removeClient(ClientKeyInterface $key)
    {
        $this->cache->delete($this->generateClientCacheKey($key));
    }
}
