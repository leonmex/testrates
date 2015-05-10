<?php
/**
 * coffee circule demo upload orders
 *
 * @author Noel Barrera
 */
namespace Coffeecircle;
//CHANGE THE PATH
require_once  "/home/nbgsys/proyects/html/coffee/app/config.php";


class CoffeeCircleAbstract
{

    private $_orders_conversion = 1;

    private $_orders_with_rates = array();

    private $_apply_rate = true;

    public function __construct()
    {
        $this->config();
    }

    private function config()
    {
        //TODO
    }

    /**
     * EXceptions
     * @param $message
     * @throws Exception
     */
    public function raiseException($message)
    {
        throw new Exception($message);
    }

    /**
     * Sort data
     *
     * @param array $arrayToSort
     * @return array
     */
    public function sortInformation(Array $arrayToSort)
    {
        $sortArray = array();

        foreach($arrayToSort as $sort){
            foreach($sort as $key=>$value){
                if(!isset($sortArray[$key])){
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $value;
            }
        }

        array_multisort($sortArray['datatosort'],SORT_ASC,$arrayToSort);

        return $arrayToSort;
    }

    private function readFile()
    {
        //for all
    }

    /**
     * Method for return save currency for all orders
     *
     * @param array $orders
     * @param array $rates
     * @param $currency
     */
    public function convertToCurrency(Array $orders, Array $rates, $currency)
    {
        foreach($orders as $order){
            if ($order['currency'] == $currency){
                $this->_apply_rate = false;
            }else{
                $this->_apply_rate = true;
            }
            switch ($order['currency']){
                case 'CHF':
                    $this->getTheRightConversorForCHF($order, $rates);
                    break;
                case 'EUR':
                    $this->getTheRightConversorForEUR($order, $rates);
                    break;
            }
        }
        /*
        foreach($this->_orders_with_rates as $o){
            echo print_r($o) . '<br />';
        }
        */
    }

    /**
     * Convert all to EUR
     *
     * @param array $orders
     * @param array $rates
     */
    public function convertToEURMethod(Array $orders, Array $rates)
    {
        foreach($orders as $order){
            switch ($order['currency']){
                case 'CHF':
                    $this->getTheRightConversorForCHF($order, $rates);
                break;
                case 'EUR':
                    $this->getTheRightConversorForEUR($order, $rates);
                break;
            }
        }
    }

    /**
     * Convert to CHF
     *
     * @param array $order
     * @param array $rates
     */
    private function getTheRightConversorForCHF(Array $order, Array $rates)
    {
        $rateToUse = $this->findTheRateForTheOrder($order, $rates);
        if(is_numeric($rateToUse)){
            $order['rate_conversion'] = $rateToUse;
            if($this->_apply_rate){
                $order['euro_conversion'] = $this->formatConversion($order['value'] /$rateToUse);
            }else{
                $order['euro_conversion'] = $order['value'];
            }
        }else{
            $order['euro_conversion'] = 0.0;

        }
        $this->setOrderWithRate($order);
    }

    /**
     * Formar number
     *
     * @param $value
     * @return string
     */
    private function formatConversion($value)
    {
        return number_format($value,DECIMAL_DIGITS,DECIMAL_SEPARATOR,'');
    }


    /**
     * Convert to EUR
     *
     * @param array $order
     * @param array $rates
     */
    private function getTheRightConversorForEUR(Array $order, Array $rates)
    {
        $rateToUse = $this->findTheRateForTheOrder($order, $rates);
        if(is_numeric($rateToUse)){
            $order['rate_conversion'] = $rateToUse;
            if($this->_apply_rate){
                $order['euro_conversion'] = $this->formatConversion($rateToUse *  $order['value']);
            }else{
                $order['euro_conversion'] = $order['value'];
            }

        }else{
            $order['euro_conversion'] = 0.0;

        }
        $this->setOrderWithRate($order);
    }


    /**
     * Find the right rate
     *
     * @param array $order
     * @param array $rates
     * @return mixed
     */
    private function findTheRateForTheOrder(Array $order, Array $rates)
    {
        list($day, $month, $year) = explode('/', $order['date']);
        $dateInUnix = mktime(0, 0, 0, $month, '01', $year);
        foreach($rates as $rate){
            if($rate['datatosort'] == $dateInUnix){
                $this->_orders_conversion ++;
                return str_replace(',','.', $rate['rate']);
            }
        }
    }

    private function setOrderWithRate(Array $orderWithRate)
    {
        $this->_orders_with_rates[] = $orderWithRate;
    }

    /**
     * HERE save the data to the database
     */
    private function saveToDatabase(){
        //TODO save the info to database
        //$this->_orders_with_rates
    }

    /**
     * Print to browser
     */
    public function outputCSV($currency){
        $strCVS = '';
        foreach($this->_orders_with_rates as $row) {
            $strCVS .= $row['orderId'] . DELIMITER_CSV;
            $strCVS .= $row['value'] . DELIMITER_CSV;
            $strCVS .= $currency . DELIMITER_CSV;
            $strCVS .= $row['date'] . DELIMITER_CSV;
            $strCVS .= $row['rate_conversion'] . DELIMITER_CSV;
            $strCVS .= $row['euro_conversion'] . DELIMITER_CSV;
            $strCVS .= $row['euro_conversion'];
        }
        echo $strCVS;
    }
}