<?php

namespace Gn\Api;

/**
 * ControllerFactoryInterface
 */
interface ControllerFactoryInterface
{

    /**
     * @param string $classNameName
     * @return ControllerInterface
     *
     * @throws \UnexpectedValueException
     */
    public function createController($classNameName);
}
