<?php

namespace Gn\Api;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ContainerFactory
 */
class ContainerFactory
{

    /**
     * @return ContainerFactory
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @return ContainerBuilder
     */
    public function generateContainer()
    {
        $container = new ContainerBuilder();

        $this->appendEnvironment($container);
        $this->appendParameters($container);
        $this->appendServices($container);

        return $container;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendEnvironment(ContainerBuilder $container)
    {
        $container->register('environment', 'Gn\Api\Environment')
            ->setFactoryClass('Gn\Api\Environment')
            ->setFactoryMethod('createFromEnvironmentVariables')
        ;
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    protected function appendParameters(ContainerBuilder $container)
    {
        $this->appendApplicationPathParameters($container);
        $this->appendDatabaseParameters($container);
        $this->appendCachingParameters($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendApplicationPathParameters(ContainerBuilder $container)
    {
        $container->setParameter('path.src', dirname(__FILE__) . '/../../');
        $container->setParameter('path.public', dirname(__FILE__) . '/../../../www');
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendCachingParameters(ContainerBuilder $container)
    {
        $container->setParameter('cache.filecache.directory', dirname(__FILE__) . '/../../../cache');
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    protected function appendDatabaseParameters(ContainerBuilder $container)
    {
        $container->setParameter('database.user', null);
        $container->setParameter('database.password', null);
        $container->setParameter('database.name', null);
        $container->setParameter('database.host', 'localhost');
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendServices(ContainerBuilder $container)
    {
        $this->appendFactories($container);
        $this->appendDoctrineServices($container);
        $this->appendServiceLocators($container);
        $this->appendCachingServices($container);
        $this->appendFirewallServices($container);
        $this->appendResponseBodyGenerators($container);
        $this->appendRouting($container);

        $container->register('request', 'Gn\Api\Request')
            ->setFactoryClass('Gn\Api\Request')
            ->setFactoryMethod('createFromGlobals')
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendRouting(ContainerBuilder $container)
    {
        $container->register('routecollection', 'Symfony\Component\Routing\RouteCollection')
            ->setFactoryClass('App\RouteCollectionFactory')
            ->setFactoryMethod('generateRoutecollection')
            ->addArgument(new Reference('factory.route'))
        ;

        $container->register('router', 'Gn\Api\Router')
            ->addMethodCall('setRouteCollection', array(new Reference('routecollection')))
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendResponseBodyGenerators(ContainerBuilder $container)
    {
        $container->register('generator.responseBody.jsonAdapter', 'Gn\Api\ResponseBodyGeneratorAdapter\Json');
        $container->register('generator.responseBoyd.xmlAdapter', 'Gn\Api\ResponseBodyGeneratorAdapter\Xml');

        $container->register('generator.responseBody', 'Gn\Api\ResponseBodyGenerator')
            ->addArgument(array(
                'application/json' => new Reference('generator.responseBody.jsonAdapter'),
                'text/xml' => new Reference('generator.responseBoyd.xmlAdapter')
            ))
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendFirewallServices(ContainerBuilder $container)
    {
        $container->register('firewall.adapter.clientkey', 'Gn\Api\FirewallAdapter\ClientKeyAdapter')
            ->addArgument(new Reference('entitymanager'))
        ;

        $container->register('firewall', 'Gn\Api\Firewall')
            ->addMethodCall('registerAdapter', array(
                'clientKey',
                new Reference('firewall.adapter.clientkey')
            ))
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendCachingServices(ContainerBuilder $container)
    {
        $container->register('cache', 'Gn\Api\Cache\FileCache')
            ->addArgument(new Directory($container->getParameter('cache.filecache.directory')))
        ;

        $container->register('cache.repository', 'Gn\Api\CacheRepository')
            ->addArgument(new Reference('cache'))
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendServiceLocators(ContainerBuilder $container)
    {
        $container->register('servicelocator.controller', 'Gn\Api\ServiceLocator\ControllerServiceLocator')
            ->addArgument($container)
        ;

        $container->register('servicelocator.gatekeeper', 'Gn\Api\ServiceLocator\GatekeeperServiceLocator')
            ->addArgument($container)
        ;

        $container->register('servicelocator.command', 'Gn\Api\ServiceLocator\CommandServiceLocator')
            ->addArgument($container)
        ;

        $container->register('servicelocator.task', 'Gn\Api\ServiceLocator\TaskServiceLocator')
            ->addArgument($container)
        ;

        $container->register('servicelocator.representation', 'Gn\Api\ServiceLocator\RepresentationServiceLocator')
            ->addArgument($container)
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendDoctrineServices(ContainerBuilder $container)
    {
        $container->register('doctrine.sqllogger', 'Gn\Api\Logger\SQLLogger');

        $container->register('doctrine.phpdriver', 'Doctrine\Common\Persistence\Mapping\Driver\PHPDriver')
            ->addArgument(array(
                $container->getParameter('path.src') . '/App/Entity',
                $container->getParameter('path.src') . 'Gn/Api/Entity'
            ))
        ;

        $container->register('doctrine.ormconfiguration', 'Doctrine\ORM\Tools\Setup')
            ->setFactoryClass('Doctrine\ORM\Tools\Setup')
            ->setFactoryMethod('createConfiguration')
            ->addArgument(true)
            ->addMethodCall('setMetadataDriverImpl', array(
                $container->get('doctrine.phpdriver')
            ))
            ->addMethodCall('setSQLLogger', array(new Reference('doctrine.sqllogger')))
        ;

        $container->register('entitymanager', 'Doctrine\ORM\EntityManager')
            ->setFactoryClass('Doctrine\ORM\EntityManager')
            ->setFactoryMethod('create')
            ->addArgument(array(
                'dbname'    => $container->getParameter('database.name'),
                'user'      => $container->getParameter('database.user'),
                'password'  => $container->getParameter('database.password'),
                'host'      => $container->getParameter('database.host'),
                'driver'    => 'pdo_mysql',
            ))
            ->addArgument(new Reference('doctrine.ormconfiguration'))
        ;
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function appendFactories(ContainerBuilder $container)
    {
        $container->register('factory.response', 'Gn\Api\ResponseFactory')
            ->addArgument(new Reference('environment'))
        ;

        $container->register('factory.controller', 'Gn\Api\ControllerFactory')
            ->addArgument(new Reference('servicelocator.controller'))
        ;

        $container->register('factory.route', 'Gn\Api\RouteFactory');

        $container->register('factory.task', 'Gn\Api\TaskFactory')
            ->addArgument(new Reference('servicelocator.task'))
        ;

        $container->register('factory.representation', 'App\RepresentationFactory')
            ->addArgument(new Reference('servicelocator.representation'))
        ;
    }
}
