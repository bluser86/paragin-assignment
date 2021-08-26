<?php

namespace Paragin\Cli\Helper;

use Paragin\Cli\Exception\Statistics\StatisticsCalculationException;

/**
 * Helper class containing certain statistic formulae.
 *
 * @package Paragin\Cli\Helper
 */
class StatisticsHelper
{
    /**
     * Calculates a grade using a non-linear caesura grading formula.
     *
     * @param float $score   Total score of a test result
     * @param float $max     Maximum possible score of a test result
     * @param float $caesura Caesura breakpoint
     * @param float $floor   Lowest grade floor
     *
     * @return float
     */
    public function nonLinearCaesuraGrade(float $score, float $max, float $caesura = 0.7, float $floor = 0.2): float
    {
        $floorScore = $floor * $max;
        $caesuraScore = $caesura * $max;

        if ($score < $floorScore) {
            return 1;
        }

        if ($score < $caesuraScore) {
            $grade = (($score - $caesuraScore) * (4.5 / ($caesuraScore - $floorScore))) + 5.5;
        } else {
            $grade = (($score - $caesuraScore) * (4.5 / ($max - $caesuraScore))) + 5.5;
        }

        return round($grade, 1);
    }

    /**
     * Calculates Pearson correlation of a question using the average scores and individual grades as samples.
     *
     * @param array $scores
     * @param array $grades
     *
     * @return float
     *
     * @throws StatisticsCalculationException
     */
    public function pearsonCorrelation(array $scores, array $grades): float
    {
        if (count($scores) !== count($grades)) {
            throw new StatisticsCalculationException('Cannot find Pearson correlation because the number of items in the scores and grades list do not match.');
        }

        try {
            $scoreAvg = $this->average($scores);
        } catch (StatisticsCalculationException $e) {
            throw new StatisticsCalculationException('Cannot find Pearson correlation due to invalid question score average.', $e);
        }

        try {
            $gradeAvg = $this->average($grades);
        } catch (StatisticsCalculationException $e) {
            throw new StatisticsCalculationException('Cannot find Pearson correlation due to invalid grade average.', $e);
        }

        $numerator = 0;
        $denominatorScores = 0;
        $denominatorGrades = 0;
        for($i = 0; $i < count($scores); $i++) {
            $score = $scores[$i];
            $grade = $grades[$i];

            $numerator += ($score - $scoreAvg) * ($grade - $gradeAvg);

            $denominatorScores += pow($score - $scoreAvg, 2);
            $denominatorGrades += pow($grade - $gradeAvg, 2);
        }

        if ($denominatorScores <= 0 || $denominatorGrades <= 0) {
            return 0;
        }

        return $numerator / sqrt($denominatorScores * $denominatorGrades);
    }

    /**
     * Calculates the P value of a question.
     *
     * @param array $scores All individual scores for a particular question.
     * @param float $max    The maximum achievable score for the question.
     *
     * @return float
     *
     * @throws StatisticsCalculationException
     */
    public function pValue(array $scores, float $max): float
    {
        try {
            return $this->average($scores) / $max;
        } catch (StatisticsCalculationException $e) {
            throw new StatisticsCalculationException('Cannot find P-value due to invalid question score average.', $e);
        }
    }

    /**
     * Quick and dirty average calculation for any list of numbers.
     *
     * @param array $numbers
     *
     * @return float
     *
     * @throws StatisticsCalculationException
     */
    public function average(array $numbers): float
    {
        if (count($numbers) === 0) {
            throw new StatisticsCalculationException('Can not find average on an empty list of numbers.');
        }

        return array_sum($numbers) / count($numbers);
    }
}