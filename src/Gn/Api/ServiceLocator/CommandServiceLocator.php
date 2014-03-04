<?php

namespace Gn\Api\ServiceLocator;

use Doctrine\ORM\EntityManagerInterface;
use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * CommandServiceLocator
 */
class CommandServiceLocator extends ServiceLocator
{

    /**
     * @var ContainerInterface
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
     * @return EntityManagerInterface
     * @throws \UnexpectedValueException
     */
    public function getEntityManager()
    {
        $entityManager = $this->diContainer->get('entitymanager');

        if (($entityManager instanceof EntityManagerInterface) === false) {
            throw new \UnexpectedValueException('EntityManager should implement the Doctrine\ORM\EntityManagerInterface');
        }

        return $entityManager;
    }
}
