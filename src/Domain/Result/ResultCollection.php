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
     * @param Result[] $results       A list of Result objects for each test candidate
     * @param float[]  $maximumScores The maximum scores for each question
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
     * Returns the sum of each individual maximum score.
     *
     * @return float
     */
    public function getTotalMaximumScore(): float
    {
        return array_sum($this->maximumScores);
    }

    /**
     * @return int
     */
    public function getNumberOfQuestions(): int
    {
        return count($this->maximumScores);
    }

    /**
     * Retrieves a list of scores for the given question number.
     *
     * @param int $question The question number to retrieve a list of scores for
     *
     * @return float[]
     */
    public function getScoresAt(int $question): array
    {
        $scores = [];

        foreach ($this->results as $result) {
            $scores[] = $result->getScoreAt($question);
        }

        return $scores;
    }

    /**
     * Get maximum score for a particular question
     *
     * @param int $question The number of the question to retrieve the maximum score for
     *
     * @return float
     */
    public function getMaximumScoreAt(int $question): float
    {
        return $this->maximumScores[$question - 1];
    }
}