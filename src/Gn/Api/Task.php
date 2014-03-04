<?php

namespace Gn\Api;

use Gn\Api\ServiceLocator\TaskServiceLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Task
 */
abstract class Task extends Command
{

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var TaskServiceLocator
     */
    protected $serviceLocator;

    /**
     * @param TaskServiceLocator $serviceLocator
     */
    public function __construct(TaskServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        parent::configure();

        $this->addOption('env', 'e', InputOption::VALUE_REQUIRED, 'The environment that this execution represents');
    }

    /**
     * @inheritdoc
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setEnvironment($input->getOption('env'));
        $this->validateInput($input);
    }

    /**
     * @param string $value
     */
    protected function setEnvironment($value)
    {
        $this->environment = new Environment($value);
    }

    /**
     * @param InputInterface $input
     */
    protected function validateInput(InputInterface $input)
    {
        // overwrite to implement
    }
}
