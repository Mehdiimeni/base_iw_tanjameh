<?php
/**
 * Version control report base class for PHP_CodeSniffer.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Ben Selby <benmatselby@gmail.com>
 * @copyright 2009-2014 SQLI <www.sqli.com>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Version control report base class for PHP_CodeSniffer.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Ben Selby <benmatselby@gmail.com>
 * @copyright 2009-2014 SQLI <www.sqli.com>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: 1.2.2
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
abstract class PHP_CodeSniffer_Reports_VersionControl implements PHP_CodeSniffer_Report
{

    /**
     * The name of the report we want in the output.
     *
     * @var string
     */
    protected $reportName = 'VERSION CONTROL';

    /**
     * A cache of author stats collected during the run.
     *
     * @var array
     */
    private $_authorCache = array();

    /**
     * A cache of blame stats collected during the run.
     *
     * @var array
     */
    private $_praiseCache = array();

    /**
     * A cache of source stats collected during the run.
     *
     * @var array
     */
    private $_sourceCache = array();


    /**
     * Generate a partial report for a single processed file.
     *
     * Function should return TRUE if it printed or stored data about the file
     * and FALSE if it ignored the file. Returning TRUE indicates that the file and
     * its data should be counted in the grand totals.
     *
     * @param array   $report      Prepared report data.
     * @param boolean $showSources Show sources?
     * @param int     $width       Maximum allowed line width.
     *
     * @return boolean
     */
    public function generateFileReport(
        $report,
        $showSources=false,
        $width=80
    ) {
        $blames = $this->getBlameContent($report['filename']);

        foreach ($report['messages'] as $line => $lineErrors) {
            $author = 'Unknown';
            if (!empty($blames[($line - 1)]) === true) {
                $blameAuthor = $this->getAuthor($blames[($line - 1)]);
                if ($blameAuthor !== false) {
                    $author = $blameAuthor;
                }
            }

            if (!empty($this->_authorCache[$author]) === false) {
                $this->_authorCache[$author] = 0;
                $this->_praiseCache[$author] = array(
                                                'good' => 0,
                                                'bad'  => 0,
                                               );
            }

            $this->_praiseCache[$author]['bad']++;

            foreach ($lineErrors as $column => $colErrors) {
                foreach ($colErrors as $error) {
                    $this->_authorCache[$author]++;

                    if ($showSources === true) {
                        $source = $error['source'];
                        if (!empty($this->_sourceCache[$author][$source]) === false) {
                            $this->_sourceCache[$author][$source] = 1;
                        } else {
                            $this->_sourceCache[$author][$source]++;
                        }
                    }
                }
            }

            unset($blames[($line - 1)]);
        }//end foreach

        // No go through and give the authors some credit for
        // all the lines that do not have errors.
        foreach ($blames as $line) {
            $author = $this->getAuthor($line);
            if ($author === false) {
                $author = 'Unknown';
            }

            if (!empty($this->_authorCache[$author]) === false) {
                // This author doesn't have any errors.
                if (PHP_CODESNIFFER_VERBOSITY === 0) {
                    continue;
                }

                $this->_authorCache[$author] = 0;
                $this->_praiseCache[$author] = array(
                                                'good' => 0,
                                                'bad'  => 0,
                                               );
            }

            $this->_praiseCache[$author]['good']++;
        }//end foreach

        return true;

    }//end generateFileReport()


    /**
     * Prints the author of all errors and warnings, as given by "version control blame".
     *
     * @param string  $cachedData    Any partial report data that was returned from
     *                               generateFileReport during the run.
     * @param int     $totalFiles    Total number of files processed during the run.
     * @param int     $totalErrors   Total number of errors found during the run.
     * @param int     $totalWarnings Total number of warnings found during the run.
     * @param boolean $showSources   Show sources?
     * @param int     $width         Maximum allowed line width.
     * @param boolean $toScreen      Is the report being printed to screen?
     *
     * @return void
     */
    public function generate(
        $cachedData,
        $totalFiles,
        $totalErrors,
        $totalWarnings,
        $showSources=false,
        $width=80,
        $toScreen=true
    ) {
        $errorsShown = ($totalErrors + $totalWarnings);
        if ($errorsShown === 0) {
            // Nothing to show.
            return;
        }

        $width = max($width, 70);
        arsort($this->_authorCache);

        echo PHP_EOL.'PHP CODE SNIFFER '.$this->reportName.' BLAME SUMMARY'.PHP_EOL;
        echo str_repeat('-', $width).PHP_EOL;
        if ($showSources === true) {
            echo 'AUTHOR   SOURCE'.str_repeat(' ', ($width - 43)).'(Author %) (Overall %) COUNT'.PHP_EOL;
            echo str_repeat('-', $width).PHP_EOL;
        } else {
            echo 'AUTHOR'.str_repeat(' ', ($width - 34)).'(Author %) (Overall %) COUNT'.PHP_EOL;
            echo str_repeat('-', $width).PHP_EOL;
        }

        foreach ($this->_authorCache as $author => $count) {
            if ($this->_praiseCache[$author]['good'] === 0) {
                $percent = 0;
            } else {
                $total   = ($this->_praiseCache[$author]['bad'] + $this->_praiseCache[$author]['good']);
                $percent = round(($this->_praiseCache[$author]['bad'] / $total * 100), 2);
            }

            $overallPercent = '('.round((($count / $errorsShown) * 100), 2).')';
            $authorPercent  = '('.$percent.')';
            $line = str_repeat(' ', (6 - strlen($count))).$count;
            $line = str_repeat(' ', (12 - strlen($overallPercent))).$overallPercent.$line;
            $line = str_repeat(' ', (11 - strlen($authorPercent))).$authorPercent.$line;
            $line = $author.str_repeat(' ', ($width - strlen($author) - strlen($line))).$line;

            echo $line.PHP_EOL;

            if ($showSources === true && !empty($this->_sourceCache[$author]) === true) {
                $errors = $this->_sourceCache[$author];
                asort($errors);
                $errors = array_reverse($errors);

                foreach ($errors as $source => $count) {
                    if ($source === 'count') {
                        continue;
                    }

                    $line = str_repeat(' ', (5 - strlen($count))).$count;
                    echo '         '.$source.str_repeat(' ', ($width - 14 - strlen($source))).$line.PHP_EOL;
                }
            }
        }//end foreach

        echo str_repeat('-', $width).PHP_EOL;
        echo 'A TOTAL OF '.$errorsShown.' SNIFF VIOLATION(S) ';
        echo 'WERE COMMITTED BY '.count($this->_authorCache).' AUTHOR(S)'.PHP_EOL;

        echo str_repeat('-', $width).PHP_EOL;
        echo 'UPGRADE TO PHP_CODESNIFFER 2.0 TO FIX ERRORS AUTOMATICALLY'.PHP_EOL;
        echo str_repeat('-', $width).PHP_EOL.PHP_EOL;

        if ($toScreen === true
            && PHP_CODESNIFFER_INTERACTIVE === false
            && class_exists('PHP_Timer', false) === true
        ) {
            echo PHP_Timer::resourceUsage().PHP_EOL.PHP_EOL;
        }

    }//end generate()


    /**
     * Extract the author from a blame line.
     *
     * @param string $line Line to parse.
     *
     * @return mixed string or false if impossible to recover.
     */
    abstract protected function getAuthor($line);


    /**
     * Gets the blame output.
     *
     * @param string $filename File to blame.
     *
     * @return array
     */
    abstract protected function getBlameContent($filename);


}//end class

?>
