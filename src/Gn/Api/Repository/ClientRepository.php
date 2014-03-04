<?php

namespace Gn\Api\Repository;

use Gn\Api\Domain\Client\Client;
use Gn\Api\Domain\Client\ClientKey;
use Gn\Api\Domain\Client\ClientRepositoryInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Client
 */
class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{

    /**
     * @param ClientKey $key
     * @return Client|null
     */
    public function findOneByKeyWithPermissions(ClientKey $key)
    {
        $qb = $this->createQueryBuilder('c')
            ->addSelect('p')
            ->where('c.key = :key')
            ->innerJoin('c.permissions', 'p')
        ;

        $qb->setParameter('key', $key->getValue());

        return $qb->getQuery()->getOneOrNullResult();
    }
}
