<?php
/**
 * A class to manage reporting.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Gabriele Santini <gsantini@sqli.com>
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2009-2014 SQLI <www.sqli.com>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

if (is_file(dirname(__FILE__).'/../CodeSniffer.php') === true) {
    include_once dirname(__FILE__).'/../CodeSniffer.php';
} else {
    include_once 'PHP/CodeSniffer.php';
}

/**
 * A class to manage reporting.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Gabriele Santini <gsantini@sqli.com>
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2009-2014 SQLI <www.sqli.com>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class PHP_CodeSniffer_Reporting
{

    /**
     * Total number of files that contain errors or warnings.
     *
     * @var int
     */
    public $totalFiles = 0;

    /**
     * Total number of errors found during the run.
     *
     * @var int
     */
    public $totalErrors = 0;

    /**
     * Total number of warnings found during the run.
     *
     * @var int
     */
    public $totalWarnings = 0;

    /**
     * A list of reports that have written partial report output.
     *
     * @var array
     */
    private $_cachedReports = array();

    /**
     * A cache of report objects.
     *
     * @var array
     */
    private $_reports = array();

    /**
     * A cache of opened tmp files.
     *
     * @var array
     */
    private $_tmpFiles = array();


    /**
     * Produce the appropriate report object based on $type parameter.
     *
     * @param string $type The type of the report.
     *
     * @return PHP_CodeSniffer_Report
     * @throws PHP_CodeSniffer_Exception If report is not available.
     */
    public function factory($type)
    {
        $type = ucfirst($type);
        if (!empty($this->_reports[$type]) === true) {
            return $this->_reports[$type];
        }

        $filename        = $type.'.php';
        $reportClassName = 'PHP_CodeSniffer_Reports_'.$type;
        if (class_exists($reportClassName, true) === false) {
            throw new PHP_CodeSniffer_Exception('Report type "'.$type.'" not found.');
        }

        $reportClass = new $reportClassName();
        if (false === ($reportClass instanceof PHP_CodeSniffer_Report)) {
            throw new PHP_CodeSniffer_Exception('Class "'.$reportClassName.'" must implement the "PHP_CodeSniffer_Report" interface.');
        }

        $this->_reports[$type] = $reportClass;
        return $this->_reports[$type];

    }//end factory()


    /**
     * Actually generates the report.
     * 
     * @param PHP_CodeSniffer_File $phpcsFile The file that has been processed.
     * @param array                $cliValues An array of command line arguments.
     * 
     * @return void
     */
    public function cacheFileReport(PHP_CodeSniffer_File $phpcsFile, array $cliValues)
    {
        if (!empty($cliValues['reports']) === false) {
            // This happens during unit testing, or any time someone just wants
            // the error data and not the printed report.
            return;
        }

        $reportData  = $this->prepareFileReport($phpcsFile);
        $errorsShown = false;

        foreach ($cliValues['reports'] as $report => $output) {
            $reportClass = $this->factory($report);

            ob_start();
            $result = $reportClass->generateFileReport($reportData, $cliValues['showSources'], $cliValues['reportWidth']);
            if ($result === true) {
                $errorsShown = true;
            }

            $generatedReport = ob_get_contents();
            ob_end_clean();

            if ($output === null && $cliValues['reportFile'] !== null) {
                $output = $cliValues['reportFile'];
            }

            if ($output === null) {
                // Using a temp file.
                if (!empty($this->_tmpFiles[$report]) === false) {
                    $this->_tmpFiles[$report] = tmpfile();
                }

                fwrite($this->_tmpFiles[$report], $generatedReport);
            } else {
                $flags = FILE_APPEND;
                if (!empty($this->_cachedReports[$report]) === false) {
                    $this->_cachedReports[$report] = true;
                    $flags = null;
                }

                file_put_contents($output, $generatedReport, $flags);
            }
        }//end foreach

        if ($errorsShown === true) {
            $this->totalFiles++;
            $this->totalErrors   += $reportData['errors'];
            $this->totalWarnings += $reportData['warnings'];
        }

    }//end cacheFileReport()


    /**
     * Actually generates the report.
     * 
     * @param string  $report      Report type.
     * @param boolean $showSources Show sources?
     * @param string  $reportFile  Report file to generate.
     * @param integer $reportWidth Report max width.
     * 
     * @return integer
     */
    public function printReport(
        $report,
        $showSources,
        $reportFile='',
        $reportWidth=80
    ) {
        $reportClass = $this->factory($report);

        if ($reportFile !== null) {
            $filename = $reportFile;
            $toScreen = false;
            ob_start();

            if (file_exists($filename) === true) {
                $reportCache = file_get_contents($filename);
            } else {
                $reportCache = '';
            }
        } else {
            if (!empty($this->_tmpFiles[$report]) === true) {
                $data        = stream_get_meta_data($this->_tmpFiles[$report]);
                $filename    = $data['uri'];
                $reportCache = file_get_contents($filename);
                fclose($this->_tmpFiles[$report]);
            } else {
                $reportCache = '';
                $filename    = null;
            }

            $toScreen = true;
        }

        $reportClass->generate(
            $reportCache,
            $this->totalFiles,
            $this->totalErrors,
            $this->totalWarnings,
            $showSources,
            $reportWidth,
            $toScreen
        );

        if ($reportFile !== null) {
            $generatedReport = ob_get_contents();
            ob_end_clean();

            if (PHP_CODESNIFFER_VERBOSITY > 0) {
                echo $generatedReport;
            }

            $generatedReport = trim($generatedReport);
            file_put_contents($reportFile, $generatedReport.PHP_EOL);
        } else if ($filename !== null && file_exists($filename) === true) {
            unlink($filename);
        }

        return ($this->totalErrors + $this->totalWarnings);

    }//end printReport()


    /**
     * Pre-process and package violations for all files.
     *
     * Used by error reports to get a packaged list of all errors in each file.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file that has been processed.
     *
     * @return array
     */
    public function prepareFileReport(PHP_CodeSniffer_File $phpcsFile)
    {
        $report = array(
                   'filename' => $phpcsFile->getFilename(),
                   'errors'   => $phpcsFile->getErrorCount(),
                   'warnings' => $phpcsFile->getWarningCount(),
                   'messages' => array(),
                  );

        if ($report['errors'] === 0 && $report['warnings'] === 0) {
            // Prefect score!
            return $report;
        }

        $errors = array();

        // Merge errors and warnings.
        foreach ($phpcsFile->getErrors() as $line => $lineErrors) {
            if (is_array($lineErrors) === false) {
                continue;
            }

            foreach ($lineErrors as $column => $colErrors) {
                $newErrors = array();
                foreach ($colErrors as $data) {
                    $newErrors[] = array(
                                    'message'  => $data['message'],
                                    'source'   => $data['source'],
                                    'severity' => $data['severity'],
                                    'type'     => 'ERROR',
                                   );
                }//end foreach

                $errors[$line][$column] = $newErrors;
            }//end foreach

            ksort($errors[$line]);
        }//end foreach

        foreach ($phpcsFile->getWarnings() as $line => $lineWarnings) {
            if (is_array($lineWarnings) === false) {
                continue;
            }

            foreach ($lineWarnings as $column => $colWarnings) {
                $newWarnings = array();
                foreach ($colWarnings as $data) {
                    $newWarnings[] = array(
                                      'message'  => $data['message'],
                                      'source'   => $data['source'],
                                      'severity' => $data['severity'],
                                      'type'     => 'WARNING',
                                     );
                }//end foreach

                if (!empty($errors[$line]) === false) {
                    $errors[$line] = array();
                }

                if (!empty($errors[$line][$column]) === true) {
                    $errors[$line][$column] = array_merge(
                        $newWarnings,
                        $errors[$line][$column]
                    );
                } else {
                    $errors[$line][$column] = $newWarnings;
                }
            }//end foreach

            ksort($errors[$line]);
        }//end foreach

        ksort($errors);
        $report['messages'] = $errors;
        return $report;

    }//end prepareFileReport()


}//end class

?>
