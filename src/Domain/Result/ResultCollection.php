<?php


namespace Paragin\Cli\Domain\Result;

/**
 * Collection class for all information contained in Result csv.
 *
 * @package Paragin\Cli\Domain\Result
 */
class ResultCollection
{
    /**
     * @var Result[]
     */
    private $results;

    /**
     * @var float[]
     */
    private $maximumScores;

    /**
     * ResultCollection constructor.
     *
     * @param Result[] $results
     * @param float[] $maximumScores
     */
    public function __construct(array $results, array $maximumScores)
    {
        $this->results = $results;
        $this->maximumScores = $maximumScores;
    }

    /**
     * @return Result[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @return float[]
     */
    public function getMaximumScores(): array
    {
        return $this->maximumScores;
    }

    /**
     * Returns the sum of each indididual maximum score.
     *
     * @return float
     */
    public function getTotalMaximumScore(): float
    {
        return array_sum($this->maximumScores);
    }
}