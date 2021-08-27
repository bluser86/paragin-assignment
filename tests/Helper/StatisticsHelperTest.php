<?php

namespace Paragin\Cli\Helper;

use Paragin\Cli\Exception\Statistics\StatisticsCalculationException;
use PHPUnit\Framework\TestCase;

/**
 * Class StatisticsHelperTest
 *
 * @package Paragin\Cli\Helper
 */
class StatisticsHelperTest extends TestCase
{
    /**
     * Test average calculation
     */
    public function testAverageCalculation(): void
    {
        $helper = new StatisticsHelper();

        $avg = $helper->average([2, 4, 6, 8]);

        $this->assertSame(5.0, $avg);
    }

    /**
     * Test average calculation throws on empty collection.
     */
    public function testAverageCalculationThrowsOnEmptyCollection(): void
    {
        $this->expectException(StatisticsCalculationException::class);

        $helper = new StatisticsHelper();

        $helper->average([]);

    }

    /**
     * Test p-value calculation.
     */
    public function testPValueCalculation(): void
    {
        $helper = new StatisticsHelper();

        $p = $helper->pValue([1, 1, 1, 1], 2);

        $this->assertSame(0.5, $p);
    }

    /**
     * Test p-value calculation throws when provided an empty score collection.
     */
    public function testPValueCalculationThrowsOnEmptyScoreCollection(): void
    {
        $this->expectException(StatisticsCalculationException::class);

        $helper = new StatisticsHelper();

        $helper->pValue([], 2);
    }

    /**
     * Test Pearson correlation calculation.
     */
    public function testPearsonCorrelationCalculation(): void
    {
        $helper = new StatisticsHelper();

        $r = $helper->pearsonCorrelation([1, 2, 1, 1, 2], [2, 1, 2, 2, 2]);

        $this->assertSame(-0.6123724356957944, $r);
    }

    /**
     * Test Pearson correlation calculation throws on mismatched collections.
     */
    public function testPearsonCorrelationCalculationThrowsOnMismatchedCollections(): void
    {
        $this->expectException(StatisticsCalculationException::class);

        $helper = new StatisticsHelper();

        $helper->pearsonCorrelation([1, 1, 1], [1, 1]);
    }

    /**
     * Test Pearson correlation calculation throws on empty collections
     */
    public function testPearsonCorrelationCalculationThrowsOnEmptyScoreCollections(): void
    {
        $this->expectException(StatisticsCalculationException::class);

        $helper = new StatisticsHelper();

        $helper->pearsonCorrelation([], []);
    }

    /**
     * Test Pearson correlation calculation returns zero on no deviation
     */
    public function testPearsonCorrelationCalculationReturnsZeroOnNoDeviation(): void
    {
        $helper = new StatisticsHelper();

        $r = $helper->pearsonCorrelation([1, 1, 1], [1, 2, 3]);

        $this->assertSame(0.0, $r);

        $r = $helper->pearsonCorrelation([1, 2, 3], [1, 1, 1]);

        $this->assertSame(0.0, $r);
    }

    /**
     * @param float $score    The test candidate total score
     * @param float $max      The maximum achievable score
     * @param float $caesura  The caesura in decimal percentage
     * @param float $floor    The lowest score that will receive the lowest grade in decimal percentage
     * @param float $expected The expected outcome
     *
     * @dataProvider nonLinearCaesuraGradeProvider
     */
    public function testNonLinearCaesuraGradeCalculation(float $score, float $max, float $caesura, float $floor, float $expected): void
    {
        $helper = new StatisticsHelper();

        $grade = $helper->nonLinearCaesuraGrade($score, $max, $caesura, $floor);

        $this->assertSame($expected, $grade);
    }

    /**
     * @return array
     */
    public function nonLinearCaesuraGradeProvider(): array
    {
        return [
            [100, 100, 0.7, 0.2, 10.0],
            [20, 100, 0.7, 0.2, 1.0],
            [70, 100, 0.7, 0.2, 5.5],
            [40, 100, 0.7, 0.2, 2.8],
        ];
    }
}