<?php

namespace Gn\Api\ServiceLocator;

use Doctrine\ORM\EntityManagerInterface;
use Gn\Api\CacheRepositoryInterface;
use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Gatekeeper class
 */
class GatekeeperServiceLocator extends ServiceLocator
{

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $diContainer;

    /**
     * @param ContainerInterface $diContainer
     */
    public function __construct(ContainerInterface $diContainer)
    {
        $this->diContainer = $diContainer;
    }

    /**
     * @return CacheRepositoryInterface
     * @throws \UnexpectedValueException
     */
    public function getCacheRepository()
    {
        $cacheRepository = $this->diContainer->get('cache.repository');

        if (($cacheRepository instanceof CacheRepositoryInterface) === false) {
            throw new \UnexpectedValueException('Gatekeeper is expecting an implementation of the CacheRepositoryInterface');
        }

        return $cacheRepository;
    }

    /**
     * @return EntityManagerInterface
     * @throws \UnexpectedValueException
     */
    public function getEntityManager()
    {
        $entityManager = $this->diContainer->get('entitymanager');

        if (($entityManager instanceof EntityManagerInterface) === false) {
            throw new \UnexpectedValueException('EntityManager should implement Doctrine\ORM\EntityManagerInterface');
        }

        return $entityManager;
    }
}
