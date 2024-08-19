<?php
/**
 * CashWeb API Abstract Record function
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

use CashWeb\Dataset;
use \Exception;
use ReflectionClass;

/**
 * Abstract Record Implementation
 */
class AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '';

    /** @var Array $record Record setup */
    protected Array $record = array();

    /** @var Array $data Data stored in this record */
    protected Array $data = array();

    /**
     * Create record from array
     * This is used to create a record from the human readable record
     * @param Array $array Array to create the record from
     * @return Self;
     */
    public function fromArray(Array $array): Self{
        $this->data = $array; return $this;
    }
    
    /**
     * Convert the current record to an array
     * This is convert to a human readable record
     * @return Array
     */
    public function toArray(): Array{
        return $this->data;
    }

    /**
     * Deassemble complete array from a response
     * @param Array $array Array to deassemble
     * @return Dataset
     */
    public function createDataset(Array $array): Dataset{
        // check if we need to extract the records
        if(array_keys($array) !== range(0, count($array) - 1)){
            $array = $array['R'.$this->recordIdentifier];
        }
        // loop trough the array
        $response = array(); foreach($array as $record){
            array_push($response, (new ReflectionClass(get_called_class()))
                ->newInstance()
                ->deassemble($record));
        }
        // return the response
        return new Dataset($response, $this->record);
    }

    /**
     * Deassemble
     * Deassemble API record to record
     * @param Array $array Array to deassemble
     * @return Self     
     */
    public function deassemble(Array $array): Self{
        // loop trough the properties
        foreach($this->record as $property => list($field, $format)){
            if(array_key_exists('F'.$field, $array)){
                switch($format){
                    case 'D':
                        $this->data[$property] = implode('-', array_reverse(explode('-', $array['F'.$field])));
                        break;
                    case 'I12,2':
                    case 'I12,2*':
                        $this->data[$property] = floatval(str_replace(',', '.', $array['F'.$field]));
                        break;
                    default:
                        $this->data[$property] = $array['F'.$field];
                }
                
            }
        }
        return $this;
    }

    /**
     * Assemable record to API record
     * @return Array
     */
    public function assemble(): Array{
        // create the empty record
        $record = array();
        // loop trough the properties
        foreach($this->record as $property => list($field, $format)){
            // check if property was set
            if(!empty($this->data[$property])){
                switch($format){
                    case 'D':
                        $record['F'.$field] = date('ymd', strtotime($this->data[$property]));
                        break;
                    case 'I12,2':
                    case 'I12,2*':
                        $this->data[$property] = intval($this->data[$property]*100);
                        break;
                    default:
                        $record['F'.$field] = $this->data[$property];
                }
                
            }
        }
        // return the record
        return array('R'.$this->recordIdentifier => $record);
    }

    /**
     * Magic call function
     * This is used to get and set variables
     * @param String $func Function that was called
     * @param Array $args Arguments for the call
     */
    public function __call(String $func, Array $args){
        // extract the function and args
        $action = substr($func, 0, 3);
		$property = lcfirst(substr($func, 3));
		// check if variable exists and if the called action was a get or set
		if(!array_key_exists($property, $this->record) || !in_array($action, array('get', 'set'))) {	
			throw new Exception('Call to undefined method '.get_called_class().'::'.$func.'()');
		}
        // get the value
        if($action === 'get'){
            return $this->data[$property];
        }
        // set the value
        $this->data[$property] = current($args);
        // return instance for chaining
        return $this;
    }

}
?>