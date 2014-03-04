<?php

namespace Gn\Api\ServiceLocator;

use Gn\Api\ServiceLocator;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * TaskServiceProvider
 */
class TaskServiceLocator extends ServiceLocator
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
}
