<?php

namespace Gn\Api;

use Gn\Api\ServiceLocator\ControllerServiceLocator;

/**
 * Controller
 */
abstract class Controller implements ControllerInterface
{

    /**
     * @var ControllerServiceLocator
     */
    protected $serviceLocator;

    /**
     * @param ControllerServiceLocator $serviceLocator
     */
    public function __construct(ControllerServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }
}
