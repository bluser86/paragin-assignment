<?php

namespace Paragin\Cli;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * Application entry point
 *
 * @package Paragin\Cli
 */
class Application extends BaseApplication
{
    /**
     * Application constructor.
     *
     * @param iterable $commands
     */
    public function __construct(iterable $commands)
    {
        parent::__construct('Paragin Assignment CLI Tool', '1.0.0');

        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}