<?php

namespace Paragin\Cli\Domain\Result\Grader;

use Paragin\Cli\Helper\StatisticsHelper;

/**
 * Takes a result tuple and calculates the grade for the test result.
 *
 * @package Paragin\Cli\Domain\Result\Grader
 */
class ResultGrader
{
    /**
     * @var StatisticsHelper
     */
    private $statisticsHelper;

    /**
     * @var float
     */
    private $caesura;

    /**
     * @var float
     */
    private $floor;

    /**
     * ResultGrader constructor.
     *
     * @param StatisticsHelper $statisticsHelper
     * @param float            $caesura The caesura at which the linear graph bends in decimal percentage
     * @param float            $floor   The decimal percentage of the score to receive the lowest grade
     */
    public function __construct(StatisticsHelper $statisticsHelper, float $caesura, float $floor)
    {
        $this->statisticsHelper = $statisticsHelper;
        $this->caesura = $caesura;
        $this->floor = $floor;
    }

    /**
     * @param float $score    The test candidates total score
     * @param float $maxScore The maximum achievable score on the test
     *
     * @return float
     */
    public function calculateGrade(float $score, float $maxScore): float
    {
        return $this->statisticsHelper->nonLinearCaesuraGrade($score, $maxScore, $this->caesura, $this->floor);
    }
}