<?php

namespace Gn\Api;

use Doctrine\ORM\EntityManagerInterface;
use Gn\Api\ServiceLocator\RepresentationServiceLocator;
use Symfony\Component\Routing\RequestContext;

/**
 * Representation
 */
abstract class Representation implements RepresentationInterface
{

    /**
     * @var RepresentationServiceLocator
     */
    protected $serviceLocator = null;

    /**
     * @var array
     */
    protected $data = null;

    /**
     * @var array
     */
    protected $related = null;

    /**
     * @var array
     */
    protected $context = null;

    /**
     * @var array
     */
    protected $commands = null;

    /**
     * @var array
     */
    protected $debug = array();

    /**
     * @param RepresentationServiceLocator $serviceLocator
     */
    public function __construct(RepresentationServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        $this->configure();
    }

    /**
     * Configures this representation
     */
    protected function configure()
    {
        $this->data = $this->configureData();
    }

    /**
     * @return array
     */
    protected function configureData()
    {
        return array();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    protected function generateAbsoluteUrl($route, array $params = array())
    {
        return $this->generateUrl($route, $params, true);
    }

    /**
     * @param string $route
     * @param array $params
     * @param bool $absolute
     *
     * @return string
     */
    protected function generateUrl($route, array $params, $absolute = false)
    {
        $requestContext = new RequestContext();
        $requestContext->fromRequest($this->serviceLocator->getRequest());

        return $this->serviceLocator->getRouter()->generateUrl($requestContext, $route, $params, $absolute);
    }

    /**
     * @param array $debug
     * @return Representation
     */
    public function setDebug(array $debug)
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * @return array
     */
    public function getDebug()
    {
        return $this->debug;
    }
}
