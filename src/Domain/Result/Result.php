<?php

namespace Paragin\Cli\Domain\Result;

/**
 * Single tuple of a result collection and a candidate name
 *
 * @package Paragin\Cli\Domain\Result
 */
class Result
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float[]
     */
    private $scores;

    /**
     * Result constructor.
     *
     * @param string $name
     * @param float[] $scores
     */
    public function __construct(string $name, array $scores)
    {
        $this->name = $name;
        $this->scores = $scores;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * Retrieve a score for a particular question.
     *
     * @param int $question
     *
     * @return float
     */
    public function getScoreAt(int $question): float
    {
        return $this->scores[$question - 1];
    }

    /**
     * Retrieve the total sum of each individual score per question.
     *
     * @return float
     */
    public function getTotalScore(): float
    {
        return array_sum($this->scores);
    }
}