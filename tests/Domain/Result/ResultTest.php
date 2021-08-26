<?php

namespace Paragin\Cli\Domain\Result;

use PHPUnit\Framework\TestCase;

/**
 * Class ResultTest
 *
 * @package Paragin\Cli\Domain\Result
 */
class ResultTest extends TestCase
{
    /**
     * Test get score at
     */
    public function testGetScoreAt(): void
    {
        $result = new Result('test', [1, 2, 3]);

        $score = $result->getScoreAt(2);

        $this->assertSame(2.0, $score);
    }

    /**
     * Test get total score
     */
    public function testGetTotalScore(): void
    {
        $result = new Result('test', [1, 2, 3]);

        $score = $result->getTotalScore();

        $this->assertSame(6.0, $score);
    }
}