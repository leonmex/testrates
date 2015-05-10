<?php
/**
 * coffee circule demo upload orders
 *
 * @author Noel Barrera
 */
require_once 'CoffeeCircleAbstract.php';
require_once 'CoffeeCircleFilesInterface.php';

use \Coffeecircle\CoffeeCircleAbstract;

class DoUploadOrders extends CoffeeCircleAbstract
            implements CoffeeCircleFilesInterface {

    private $_types_of_files = array('text/csv'=>1);

    private $_tmp_file = '';
    private $_real_name = '';

    private $_fileToWorkWith = '';

    private $_dataInTheOrderFile = array();
    private $_allOrdersWithSort = array();

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Read orders
     *
     * @param array $file
     * @return bool
     */
    public function readOrdersFile(Array $file)
    {
        if(isset($file['orderfile'])){
            if( $this->validateFile($file['orderfile']) ){
                $this->readFile();
                $this->_allOrdersWithSort = $this->sortInformation($this->_dataInTheOrderFile);
            }
        }else{
            return false;
        }

    }

    /**
     * Return values
     *
     * @return array
     */
    public function getAllOrderWithSort()
    {
        return $this->_allOrdersWithSort;
    }


    /**
     * Validate files in server
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
     * Read de CSV file
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
            if (ORDERS_FILE_COLUMNS == $countColumnsInTheRow){
                $linesInTheFile++;
                list($orderId, $value, $currency, $orderDate) = $dataInTheFile;
                $dateOfTheOrder = str_replace('.','/',$orderDate);
                list($day, $month, $year) = explode('/', $dateOfTheOrder);
                $dateToSort = mktime(0,0,0,$month, '01', $year);
                $rowToInsert = array('orderId'=>$orderId, 'value'=>$value, 'currency'=>$currency, 'date'=>$dateOfTheOrder, 'datatosort'=>$dateToSort);
                if ( is_numeric($rowToInsert['orderId']) ){
                    $this->setData($rowToInsert);
                }
            }
        }
        fclose($this->_fileToWorkWith);
    }

    /**
     * @param array $dataLine
     */
    private function setData(Array $dataLine)
    {

        $this->_dataInTheOrderFile[] = $dataLine;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->_dataInTheOrderFile;
    }

}