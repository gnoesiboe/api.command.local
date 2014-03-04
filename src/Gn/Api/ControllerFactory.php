<?php

namespace Gn\Api;

use Gn\Api\ServiceLocator\ControllerServiceLocator;

/**
 * ControllerFactory
 */
class ControllerFactory implements ControllerFactoryInterface
{


    /**
     * @var ServiceLocator\ControllerServiceLocator
     */
    protected $serviceLocator;

    /**
     * @param ControllerServiceLocator $serviceLocator
     */
    public function __construct(ControllerServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param string $className
     * @return ControllerInterface
     *
     * @throws \UnexpectedValueException
     */
    public function createController($className)
    {
        if (class_exists($className) === false) {
            throw new \UnexpectedValueException(sprintf('No controller with class: \'%s\' exists', $className));
        }

        $instance = new $className($this->serviceLocator);

        if (($instance instanceof ControllerInterface) === false) {
            throw new \UnexpectedValueException(sprintf('Class: \'%s\' should be an instanceof of ControllerInterface', $className));
        }

        return $instance;
    }
}
