<?php

namespace Gn\Api\Task;

use Gn\Api\Task;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ClearCacheTask
 */
class ClearCacheTask extends Task
{

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('gn:cache:clear')
            ->setDescription('Clears the cache')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $command = sprintf('rm -rvf %s', dirname(__FILE__) . '/../../../../cache/*');

        $output->writeln('command to be executed: ' . $command);

        exec($command, $execOutput);

        $output->write($execOutput);
    }
}
