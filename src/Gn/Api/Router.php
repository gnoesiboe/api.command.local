<?php

namespace Gn\Api;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation;

/**
 * Router
 */
class Router implements RouterInterface
{

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setRouteCollection(new RouteCollection());
    }

    /**
     * @param RouteCollection $routeCollection
     * @return Router
     */
    public function setRouteCollection(RouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;

        return $this;
    }

    /**
     * @param HttpFoundation\Request $request
     *
     * @return array
     *
     * @throws \UnexpectedValueException
     */
    public function match(HttpFoundation\Request $request)
    {
        $requestContext = new RequestContext();
        $requestContext->fromRequest($request);

        $urlMatcher = new UrlMatcher($this->routeCollection, $requestContext);

        $parameters = $urlMatcher->matchRequest($request);

        if (array_key_exists('_route', $parameters) === false) {
            throw new \UnexpectedValueException('Expecting _route key in parameters array');
        }

        return $parameters;
    }

    /**
     * @param RequestContext $context
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     *
     * @return string
     */
    public function generateUrl(RequestContext $context, $name, array $parameters, $absolute = false)
    {
        $urlGenerator  = new UrlGenerator($this->routeCollection, $context);

        return $urlGenerator->generate($name, $parameters, $absolute);
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        return $this->routeCollection;
    }
}
