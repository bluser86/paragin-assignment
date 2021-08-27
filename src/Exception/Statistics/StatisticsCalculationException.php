<?php

namespace Paragin\Cli\Exception\Statistics;

use Throwable;

/**
 * Exception thrown from the StatisticsHelper class.
 *
 * @package Paragin\Cli\Exception
 */
class StatisticsCalculationException extends \RuntimeException
{
    /**
     * StatisticsCalculationException constructor.
     *
     * @param string         $message  The exception message
     * @param Throwable|null $previous Any previous exception thrown
     */
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}