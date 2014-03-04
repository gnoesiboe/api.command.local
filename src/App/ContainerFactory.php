<?php

namespace App;

use Gn\Api\Directory;
use Gn\Api\Environment;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * ContainerBuilder
 */
class ContainerFactory extends \Gn\Api\ContainerFactory
{

    /**
     * @param ContainerBuilder $container
     *
     * @throws \UnexpectedValueException
     * @throws \Exception
     */
    protected function appendDatabaseParameters(ContainerBuilder $container)
    {
        parent::appendDatabaseParameters($container);

        $database = array(
            'user' => null,
            'password' => null,
            'name' => null,
            'host' => 'localhost'
        );

        /** @var Environment $environment */
        $environment = $container->get('environment');

        switch ($environment->getValue())
        {
            case Environment::PRODUCTION:
                throw new \Exception('todo'); //@todo
                break;

            case Environment::STAGING:
                throw new \Exception('todo'); //@todo
                break;

            case Environment::DEVELOPMENT:
                $database['user'] = 'root';
                $database['name'] = 'command_api_dev';
                break;

            case Environment::TEST:
                throw new \Exception('todo'); //@todo
                break;

            default:
                throw new \UnexpectedValueException(sprintf('Environment \'%s\' not supported', $environment->getValue()));
        }

        $container->setParameter('database.user', $database['user']);
        $container->setParameter('database.password', $database['password']);
        $container->setParameter('database.name', $database['name']);
        $container->setParameter('database.host', $database['host']);
    }
}
