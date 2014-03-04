<?php

namespace Gn\Api\ServiceLocator;

use Gn\Api\ControllerFactory;
use Gn\Api\ControllerFactoryInterface;
use Gn\Api\Environment;
use Gn\Api\FirewallInterface;
use Gn\Api\Logger\SQLLogger;
use Gn\Api\Request;
use Gn\Api\ResponseBodyGeneratorInterface;
use Gn\Api\ResponseFactory;
use Gn\Api\RouteInterface;
use Gn\Api\RouterInterface;
use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * RequestHandlerServiceLocator
 *
 * Holds all the dependencies for the app
 */
class RequestHandlerServiceLocator extends ServiceLocator
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
     * @return RouteCollection
     * @throws \UnexpectedValueException
     */
    public function getRouteCollection()
    {
        $routeCollection = $this->diContainer->get('routecollection');

        if (($routeCollection instanceof RouteCollection) === false) {
            throw new \UnexpectedValueException('RouteCollection should be an instance of Symfony\Component\Routing\RouteCollection');
        }

        return $routeCollection;
    }

    /**
     * @return RouteInterface
     * @throws \UnexpectedValueException
     */
    public function getRouter()
    {
        $router = $this->diContainer->get('router');

        if (($router instanceof RouterInterface) === false) {
            throw new \UnexpectedValueException('Router instance should implement the Gn\Api\RouterInterface');
        }

        return $router;
    }

    /**
     * @return Environment
     * @throws \UnexpectedValueException
     */
    public function getEnvironment()
    {
        $environment = $this->diContainer->get('environment');

        if (($environment instanceof Environment) === false) {
            throw new \UnexpectedValueException('Environment should be in instance of Gn\Api\Environment');
        }

        return $environment;
    }

    /**
     * @return SQLLogger
     * @throws \UnexpectedValueException
     */
    public function getDoctrineSqlLogger()
    {
        $sqlLogger = $this->diContainer->get('doctrine.sqllogger');

        if (($sqlLogger instanceof SQLLogger) === false) {
            throw new \UnexpectedValueException('Doctrine sqlLogger should be an instance of Gn\Api\Logger\SQLLogger');
        }

        return $sqlLogger;
    }

    /**
     * @return ControllerServiceLocator
     * @throws \UnexpectedValueException
     */
    public function getControllerServiceLocator()
    {
        $controllerServiceLocator = $this->diContainer->get('servicelocator.controller');

        if (($controllerServiceLocator instanceof ControllerServiceLocator) === false) {
            throw new \UnexpectedValueException('Controller service locator should be an instance of Gn\Api\ControllerServiceLocator');
        }

        return $controllerServiceLocator;
    }

    /**
     * @throws \UnexpectedValueException
     * @return ResponseFactory
     *
     * @todo validate by interface?
     */
    public function getResponseFactory()
    {
        $responseFactory = $this->diContainer->get('factory.response');

        if (($responseFactory instanceof ResponseFactory) === false) {
            throw new \UnexpectedValueException('Response Factory should be in an instance of Gn\Api\ResponseFactory');
        }

        return $responseFactory;
    }

    /**
     * @return ControllerFactoryInterface
     * @throws \UnexpectedValueException
     */
    public function getControllerFactory()
    {
        $controllerFactory = $this->diContainer->get('factory.controller');

        if (($controllerFactory instanceof ControllerFactoryInterface) === false) {
            throw new \UnexpectedValueException('Controller factory should implement Gn\Api\ControllerFactoryInterface');
        }

        return $controllerFactory;
    }

    /**
     * @return Request
     * @throws \UnexpectedValueException
     *
     * @todo validate by interface?
     */
    public function getRequest()
    {
        $request = $this->diContainer->get('request');

        if (($request instanceof Request) === false) {
            throw new \UnexpectedValueException('Request should be an instance of Gn\Api\Request');
        }

        return $request;
    }

    /**
     * @return FirewallInterface
     * @throws \UnexpectedValueException
     */
    public function getFirewall()
    {
        $firewall = $this->diContainer->get('firewall');

        if (($firewall instanceof FirewallInterface) === false) {
            throw new \UnexpectedValueException('Firewall should implement Gn\Api\FirewallInterface');
        }

        return $firewall;
    }

    /**
     * @return ResponseBodyGeneratorInterface
     * @throws \UnexpectedValueException
     */
    public function getResponseBodyGenerator()
    {
        $responseBodyGenerator = $this->diContainer->get('generator.responseBody');

        if (($responseBodyGenerator instanceof ResponseBodyGeneratorInterface) === false) {
            throw new \UnexpectedValueException('Response body generator should implement Gn\Api\ResponseBodyGeneratorInterface');
        }

        return $responseBodyGenerator;
    }
}
