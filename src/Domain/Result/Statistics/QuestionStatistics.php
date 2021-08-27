<?php

namespace Paragin\Cli\Domain\Result\Statistics;

use Paragin\Cli\Helper\StatisticsHelper;

/**
 * Class QuestionStatistics
 *
 * @package Paragin\Cli\Domain\Result\Statistics
 */
class QuestionStatistics
{
    /**
     * @var StatisticsHelper
     */
    private $statisticsHelper;

    /**
     * QuestionStatistics constructor.
     *
     * @param StatisticsHelper $statisticsHelper
     */
    public function __construct(StatisticsHelper $statisticsHelper)
    {
        $this->statisticsHelper = $statisticsHelper;
    }

    /**
     * @param float[] $scores All test candidate scores for a particular question
     * @param float[] $grades All test candidate grades
     *
     * @return float
     */
    public function calculatePearsonCorrelation(array $scores, array $grades): float
    {
        return $this->statisticsHelper->pearsonCorrelation($scores, $grades);
    }

    /**
     * @param float[] $scores All test candidate scores for a particular question
     * @param float   $max    The maximum score for that same question
     *
     * @return float
     */
    public function calculatePValue(array $scores, float $max): float
    {
        return $this->statisticsHelper->pValue($scores, $max);
    }
}