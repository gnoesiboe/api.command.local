<?php

namespace Gn\Api;

use Gn\Api\Domain\Client\ClientInterface;
use Gn\Api\Domain\Client\ClientKeyInterface;

/**
 * CacheRepository
 */
interface CacheRepositoryInterface
{

    /**
     * @param ClientKeyInterface $key
     * @param mixed $default
     *
     * @return ClientInterface|mixed
     */
    public function getClient(ClientKeyInterface $key, $default = null);

    /**
     * @param ClientInterface $client
     */
    public function saveClient(ClientInterface $client);

    /**
     * @param ClientKeyInterface $key
     */
    public function removeClient(ClientKeyInterface $key);
}
