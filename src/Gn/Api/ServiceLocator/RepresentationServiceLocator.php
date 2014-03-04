<?php

namespace Gn\Api\ServiceLocator;

use Gn\Api\Request;;
use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * RepresentationServiceLocator
 */
class RepresentationServiceLocator extends ServiceLocator
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
     * @return Request
     * @throws \UnexpectedValueException
     */
    public function getRequest()
    {
        $request = $this->diContainer->get('request');

        if (($request instanceof Request) === false) {
            throw new \UnexpectedValueException('Request should be an instance of Gn\Api\Request');
        }

        return $request;
    }
}
