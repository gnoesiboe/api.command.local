<?php

namespace Gn\Api;

use Gn\Api\ServiceLocator\TaskServiceLocator;
use Gn\Api\Task\ClearCacheTask;

/**
 * TaskFactory
 */
class TaskFactory
{

    /**
     * @var ServiceLocator\TaskServiceLocator
     */
    protected $serviceLocator;

    /**
     * @param TaskServiceLocator $serviceLocator
     */
    public function __construct(TaskServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @return ClearCacheTask
     */
    public function generateClearCacheTask()
    {
        return new ClearCacheTask($this->serviceLocator);
    }
}
