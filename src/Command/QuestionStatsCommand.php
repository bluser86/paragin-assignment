<?php


namespace Paragin\Cli\Command;


use Paragin\Cli\Domain\Result\Grader\ResultGrader;
use Paragin\Cli\Domain\Result\Parser\ResultParser;
use Paragin\Cli\Domain\Result\ResultCollection;
use Paragin\Cli\Domain\Result\Statistics\QuestionStatistics;
use Paragin\Cli\Helper\StatisticsHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to display an overview of different stats per question.
 *
 * @package Paragin\Cli\Command
 */
class QuestionStatsCommand extends Command
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
     * @var QuestionStatistics
     */
    private $questionStatistics;

    /**
     * @var string
     */
    private $varDir;

    /**
     * QuestionStatsCommand constructor.
     * @param ResultParser $resultParser
     * @param ResultGrader $resultGrader
     * @param QuestionStatistics $questionStatistics
     *
     * @param string $varDir
     */
    public function __construct(ResultParser $resultParser, ResultGrader $resultGrader, QuestionStatistics $questionStatistics, string $varDir)
    {
        parent::__construct('question-stats');

        $this->resultParser = $resultParser;
        $this->resultGrader = $resultGrader;
        $this->questionStatistics = $questionStatistics;
        $this->varDir = $varDir;
    }

    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setDescription('Displays an overview of different statistics per question or all questions.')
            ->addOption('full', 'a', InputOption::VALUE_NONE | InputOption::VALUE_NONE, 'Display an overview of all questions')
            ->addArgument('question', InputArgument::OPTIONAL, 'The nubmer of the question to run some stats on');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $full = $input->getOption('full');
        $question = $input->getArgument('question');

        if (!$full && $question === null) {
            $output->writeln('<error>Please provide a question number</error>');

            return 1;
        }

        $resultCollection = $this->resultParser->getResults($this->varDir . '/Assignment.csv');

        $grades = [];
        foreach($resultCollection->getResults() as $result) {
            $grades[] = $this->resultGrader->calculateGrade($result->getTotalScore(), $resultCollection->getTotalMaximumScore());
        }

        $table = new Table($output);
        $table->setHeaders([
            'Question',
            'r',
            'P\''
        ]);

        if ($full) {
            $this->renderFull($resultCollection, $grades, $table);
        } else {
            $this->renderSingle($resultCollection, $grades, $table, $question);
        }

        $table->render();

        return 0;
    }

    /**
     * @param ResultCollection $resultCollection
     * @param array $grades
     * @param Table $table
     */
    private function renderFull(ResultCollection $resultCollection, array $grades, Table $table): void
    {
        for ($i = 1; $i <= $resultCollection->getNumberOfQuestions(); $i++) {
            $this->renderSingle($resultCollection, $grades, $table, $i);
        }
    }

    /**
     * @param ResultCollection $resultCollection
     * @param array $grades
     * @param Table $table
     * @param int $question
     */
    private function renderSingle(ResultCollection $resultCollection, array $grades, Table $table, int $question): void
    {
        $scores = $resultCollection->getScoresAt($question);
        $max = $resultCollection->getMaximumScoreAt($question);

        $r = $this->questionStatistics->calculatePearsonCorrelation($scores, $grades);
        $p = $this->questionStatistics->calculatePValue($scores, $max);

        $table->addRow([
            $question,
            $r,
            $p,
        ]);
    }
}