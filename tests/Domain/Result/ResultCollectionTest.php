<?php

namespace Paragin\Cli\Domain\Result;

use PHPUnit\Framework\TestCase;

/**
 * Class ResultCollectionTest
 *
 * @package Paragin\Cli\Domain\Result
 */
class ResultCollectionTest extends TestCase
{
    /**
     * Test get total maximum score
     */
    public function testGetTotalMaximumScore(): void
    {
        $resultCollection = new ResultCollection([], [1, 2, 3]);

        $totalMaximumScore = $resultCollection->getTotalMaximumScore();

        $this->assertSame(6.0, $totalMaximumScore);
    }

    /**
     * Test get number of questions
     */
    public function testGetNumberOfQuestions(): void
    {
        $resultCollection = new ResultCollection([], [1, 2, 3]);

        $numberOfQuestions = $resultCollection->getNumberOfQuestions();

        $this->assertSame(3, $numberOfQuestions);
    }

    /**
     * Test get scores at
     */
    public function testGetScoresAt(): void
    {
        $results = [
            new Result('test1', [1, 2, 3]),
            new Result('test2', [1, 2, 3]),
            new Result('test3', [1, 2, 3]),
        ];

        $resultCollection = new ResultCollection($results, []);

        $scores = $resultCollection->getScoresAt(2);

        $this->assertSame([2.0, 2.0, 2.0], $scores);
    }

    /**
     * Test get maximum score at
     */
    public function testGetMaximumScoreAt(): void
    {
        $resultCollection = new ResultCollection([], [1, 2, 3]);

        $maximumScore = $resultCollection->getMaximumScoreAt(3);

        $this->assertSame(3.0, $maximumScore);
    }
}