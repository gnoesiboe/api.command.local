<?php

namespace Gn\Api;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation;

/**
 * RouterInterface
 */
interface RouterInterface
{

    /**
     * @param RouteCollection $routeCollection
     * @return RouterInterface
     */
    public function setRouteCollection(RouteCollection $routeCollection);

    /**
     * @param HttpFoundation\Request $request
     * @return array
     */
    public function match(HttpFoundation\Request $request);

    /**
     * @param RequestContext $context
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     *
     * @return string
     */
    public function generateUrl(RequestContext $context, $name, array $parameters, $absolute = false);

    /**
     * @return RouteCollection
     */
    public function getRouteCollection();
}
