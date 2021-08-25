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
     * @return array
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * Retrieve a score for a particular question.
     *
     * @param int $i
     *
     * @return float
     */
    public function getScoreAt(int $i): float
    {
        return $this->scores[$i - 1];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}