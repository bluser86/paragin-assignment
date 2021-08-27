<?php

namespace Paragin\Cli\Command;

use Paragin\Cli\Domain\Result\Grader\ResultGrader;
use Paragin\Cli\Domain\Result\Parser\ResultParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command outputting all grades for a test result.
 *
 * @package Paragin\Cli\Command
 */
class GradeCommand extends Command
{
    /**
     * @var ResultParser
     */
    private $resultParser;

    /**
     * @var ResultGrader
     */
    private $resultGrader;

    /**
     * @var string
     */
    private $varDir;

    /**
     * GradeCommand constructor.
     *
     * @param ResultParser $resultParser
     * @param ResultGrader $resultGrader
     * @param string       $varDir
     */
    public function __construct(ResultParser $resultParser, ResultGrader $resultGrader, string $varDir)
    {
        parent::__construct('grades');

        $this->resultParser = $resultParser;
        $this->resultGrader = $resultGrader;
        $this->varDir = $varDir;
    }

    /**
     * Configure
     */
    protected function configure()
    {
        $this->setDescription('Creates a grade overview based on a correctly formatted test result CSV file');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resultCollection = $this->resultParser->getResults($this->varDir . '/Assignment.csv');

        $table = new Table($output);
        $table->setHeaders([
            'Name',
            'Grade',
        ]);

        foreach ($resultCollection->getResults() as $result) {
            $grade = $this->resultGrader->calculateGrade($result->getTotalScore(), $resultCollection->getTotalMaximumScore());

            $table->addRow([$result->getName(), number_format($grade, 1)]);
        }

        $table->render();

        return 0;
    }

}