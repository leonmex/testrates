<?php
/**
 * coffee circule demo upload rates
 *
 * @author Noel Barrera
 */
require_once 'CoffeeCircleAbstract.php';
require_once 'CoffeeCircleFilesInterface.php';

use \Coffeecircle\CoffeeCircleAbstract;

class DoUploadRates extends CoffeeCircleAbstract
    implements CoffeeCircleFilesInterface {

    private $_types_of_files = array('text/csv'=>1);

    private $_tmp_file = '';
    private $_real_name = '';

    private $_fileToWorkWith = '';

    private $_dataInTheRatesFile = array();

    private $_allRatesWithSort = array();

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Read
     *
     * @param array $file
     * @return bool
     */
    public function readRatesFile(Array $file)
    {
        if(isset($file['ratesfile'])){
            if( $this->validateFile($file['ratesfile']) ){
                $this->readFile();
                $this->_allRatesWithSort = $this->sortInformation($this->_dataInTheRatesFile);
            }
        }else{
            return false;
        }

    }

    /**
     * Return sort data
     *
     * @return array
     */
    public function getAllRatesWithSort()
    {
        return $this->_allRatesWithSort;
    }


    /**
     * Validate file
     *
     * @param array $file
     * @return bool|mixed
     */
    public function validateFile(Array $file)
    {
        if( !$this->_types_of_files[$file['type']] ){
            $this->raiseException('The Type of the file ' . $file['name'] . ' is not correct.');
        }
        if( $file['error'] ){
            $this->raiseException('The file ' . $file['name'] . ' have some error in the system contact to the Administrator.');
        }

        if( file_exists($file['tmp_name']) ){
            $this->_fileToWorkWith = fopen("$file[tmp_name]", "r");
        }else{
            $this->raiseException('The file ' . $file['name'] . ' is not in the system contact to the Administrator.');
        }

        return true;
    }

    /**
     * Read File
     */
    private function readFile()
    {
        $excludeFirstLine = EXCLUDE_FIRST_LINE_CSV;
        $linesInTheFile = 1;
        while (($dataInTheFile = fgetcsv($this->_fileToWorkWith, 1000, DELIMITER_CSV)) !== FALSE) {
            $countColumnsInTheRow = count($dataInTheFile);
            if ( $excludeFirstLine ){
                $excludeFirstLine = false;
                continue;
            }
            if (RATES_FILE_COLUMNS == $countColumnsInTheRow){
                $linesInTheFile++;
                list($date, $value) = $dataInTheFile;
                $dateOfTheOrder = date(DATE_FORMAT_RATES, strtotime($date.'-01'));

                list($year, $month, $day) = explode('/', $dateOfTheOrder);
                $dateToSort = mktime(0,0,0,$month, $day, $year);
                $rowToInsert = array('date'=>$date, 'rate'=>$value, 'datatosort'=>$dateToSort);
                if ( $rowToInsert['rate'] !='' ){
                    $this->setData($rowToInsert);
                }
            }else{
                $this->excludeRowFromTheFile($dataInTheFile);
            }
        }
        fclose($this->_fileToWorkWith);
    }

    /**
     * @param array $dataLine
     */
    private function setData(Array $dataLine)
    {

        $this->_dataInTheRatesFile[] = $dataLine;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_dataInTheRatesFile;
    }

}