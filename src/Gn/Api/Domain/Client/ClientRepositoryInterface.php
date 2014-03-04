<?php

namespace Gn\Api\Domain\Client;

/**
 * ClientRepository
 */
interface ClientRepositoryInterface
{

    /**
     * @param ClientKey $key
     * @return Client
     */
    public function findOneByKeyWithPermissions(ClientKey $key);
}
