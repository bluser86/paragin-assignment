<?php

namespace Paragin\Cli\Domain\Result\Parser;

use Paragin\Cli\Domain\Result\Result;
use Paragin\Cli\Domain\Result\ResultCollection;

/**
 * Parser that processes a CSV document with scores.
 *
 * Layout of CSV document:
 *  - Header of question ID's
 *  - Second row contains maximum value of each question
 *  - First column contains name of test candidate
 *  - Rest of the rows are populated with scores for the correlating question in the header
 *
 * @package Paragin\Cli\Domain\Result\Parser
 */
class ResultParser
{
    /**
     * Parses a file by filename and returns an array of Results
     *
     * @param string $fileName Relative to the CSV document
     *
     * @return ResultCollection
     */
    public function getResults(string $fileName): ResultCollection
    {
        $maxScores = [];
        $results = [];

        $row = 1;
        if (($handle = fopen($fileName, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($row === 2) {
                    // max question score row
                    for($i = 1; $i < count($data); $i++) {
                        $maxScores[] = (float) $data[$i];
                    }
                } else if ($row > 2) {
                    // regular score rows
                    $name = $data[0];
                    $scores = [];
                    for($i = 1; $i < count($data); $i++) {
                        $scores[] = (float) $data[$i];
                    }

                    $results[] = new Result($name, $scores);
                }

                $row++;
            }
            fclose($handle);
        }

        return new ResultCollection($results, $maxScores);
    }
}