<?php

namespace Gn\Api\ServiceLocator;

use Doctrine\ORM\EntityManagerInterface;
use Gn\Api\RepresentationFactory;
use Gn\Api\RouteFactory;
use Gn\Api\Router;
use Gn\Api\RouterInterface;
use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ControllerServiceLocator
 */
class ControllerServiceLocator extends ServiceLocator
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
            throw new \UnexpectedValueException('EntityManager should implement Doctrine\ORM\EntityManagerInterface');
        }

        return $entityManager;
    }

    /**
     * @return Router
     * @throws \UnexpectedValueException
     */
    public function getRouter()
    {
        $router = $this->diContainer->get('router');

        if (($router instanceof RouterInterface) === false) {
            throw new \UnexpectedValueException('Router should implement Gn\Api\RouterInterface');
        }

        return $router;
    }

    /**
     * @return CommandServiceLocator
     * @throws \UnexpectedValueException
     */
    public function getCommandServiceLocator()
    {
        $commandServiceLocator = $this->diContainer->get('servicelocator.command');

        if (($commandServiceLocator instanceof CommandServiceLocator) === false) {
            throw new \UnexpectedValueException('CommandServiceContainer should be an instance of Gn\Api\ServiceLocator\CommandServiceLocator');
        }

        return $commandServiceLocator;
    }

    /**
     * @return RouteFactory
     * @throws \UnexpectedValueException
     */
    public function getRouteFactory()
    {
        $routeFactory = $this->diContainer->get('factory.route');

        if (($routeFactory instanceof RouteFactory) === false) {
            throw new \UnexpectedValueException('RouteFactory should be an instance of use Gn\Api\RouteFactory');
        }

        return $routeFactory;
    }

    /**
     * @return RepresentationFactory
     * @throws \UnexpectedValueException
     */
    public function getRepresentationFactory()
    {
        $representationFactory = $this->diContainer->get('factory.representation');

        if (($representationFactory instanceof RepresentationFactory) === false) {
            throw new \UnexpectedValueException('RepresentationFactory should be an instance of Gn\Api\RepresentationFactory');
        }

        return $representationFactory;
    }
}
