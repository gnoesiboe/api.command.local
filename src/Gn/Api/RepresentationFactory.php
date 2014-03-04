<?php

namespace Gn\Api;

use Gn\Api\ServiceLocator\RepresentationServiceLocator;

/**
 * RepresentationFactory
 */
abstract class RepresentationFactory
{

    /**
     * @var RepresentationServiceLocator
     */
    protected $representationServiceLocator;

    /**
     * @param RepresentationServiceLocator $representationServiceLocator
     */
    public function __construct(RepresentationServiceLocator $representationServiceLocator)
    {
        $this->representationServiceLocator = $representationServiceLocator;
    }
}
