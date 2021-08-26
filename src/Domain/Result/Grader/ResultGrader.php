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
     * @param float $caesura
     * @param float $floor
     */
    public function __construct(StatisticsHelper $statisticsHelper, float $caesura, float $floor)
    {
        $this->statisticsHelper = $statisticsHelper;
        $this->caesura = $caesura;
        $this->floor = $floor;
    }

    /**
     * @param float $score
     * @param float $maxScore
     *
     * @return float
     */
    public function calculateGrade(float $score, float $maxScore): float
    {
        return $this->statisticsHelper->nonLinearCaesuraGrade($score, $maxScore, $this->caesura, $this->floor);
    }
}