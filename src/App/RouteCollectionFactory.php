<?php

namespace App;

use Gn\Api\Domain\Permission\PermissionIdentifier;
use Gn\Api\Firewall\ClientKeyFirewall;
use Gn\Api\RouteFactory;
use Symfony\Component\Routing\RouteCollection;

/**
 * RouterFactory
 */
class RouteCollectionFactory
{

    /**
     * @param RouteFactory $routeFactory
     * @return RouteCollection
     */
    public static function generateRoutecollection(RouteFactory $routeFactory)
    {
        $routeCollection = new RouteCollection();

        self::appendNewsitemResources($routeFactory, $routeCollection);
        self::appendCategoryResources($routeFactory, $routeCollection);

        return $routeCollection;
    }

    /**
     * @param RouteFactory $routeFactory
     * @param RouteCollection $routeCollection
     */
    private static function appendNewsitemResources(RouteFactory $routeFactory, RouteCollection $routeCollection)
    {
        $entityName = 'newsitem';

        $routeCollection->add(
            $routeFactory->generateDetailIdentifier($entityName),
            $routeFactory->generateDetailRoute(
                $entityName,
                array('GET'),
                array('clientKey'),
                array(new PermissionIdentifier('newsitem_get'))
            )
        );

        $routeCollection->add(
            $routeFactory->generateIndexIdentifier($entityName),
            $routeFactory->generateIndexRoute(
                $entityName,
                array('GET'),
                array('clientKey'),
                array(new PermissionIdentifier('newsitem_get'))
            )
        );
    }

    /**
     * @param RouteFactory $routeFactory
     * @param RouteCollection $routeCollection
     */
    private static function appendCategoryResources(RouteFactory $routeFactory, RouteCollection $routeCollection)
    {
        $entity = 'category';

        $routeCollection->add(
            $routeFactory->generateDetailIdentifier($entity),
            $routeFactory->generateDetailRoute(
                $entity,
                array('GET'),
                array('clientKey'),
                array(new PermissionIdentifier('category_get'))
            )
        );

        $routeCollection->add(
            $routeFactory->generateIndexIdentifier($entity),
            $routeFactory->generateIndexRoute(
                $entity,
                array('GET'),
                array('clientKey'),
                array(new PermissionIdentifier('category_get'))
            )
        );
    }
}
