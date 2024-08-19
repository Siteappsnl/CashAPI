<?php
/**
 * CashWeb Dataset
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb;

use CashWeb\Records\AbstractRecord;

use Iterator;
use Countable;
use Exception;

/**
 * Dataset implementation
 */
class Dataset implements Iterator, Countable{

    /** @var int $idx Current index */
    private $idx = 0;

    /** @var Array $data Data for this dataset */
    private Array $data = array();

    /** @var Array $record Record definition for this dataset */
    private Array $record = array();

    /**
     * Class Contructor loads the data
     * @param Array $data Data to initableize the dataset with
     * @param Array $record Record definition inside the data
     */
    public function __construct(Array $data, Array $record){
        $this->data = $data; $this->record = $record;
    }

    /**
     * Count the values inside the response
     * @return Int
     */
    public function count(): Int{
        return count($this->data);
    }

    /**
     * Array function rewind
     */
    public function rewind(): Void{
        $this->idx = 0;
    }

    /**
     * Array function current
     * @return mixed
     */
    public function current(): AbstractRecord{ 
        return $this->data[$this->idx];
    }

    /**
     * Array key function
     * @return int
     */
    public function key(): Int{
        return $this->idx;
    }

    /**
     * Array next function
     */
    public function next(): Void{
        ++$this->idx;
    }

    /**
     * Array valid function
     * @return bool
     */
    public function valid(): Bool{
        return !empty($this->data[$this->idx]);
    }

    /**
     * Convert all to array
     * @return Array
     */
    public function toArray(): Array{
        $response = array(); foreach($this->data as $record){
            array_push($response, $record->toArray());
        }
        return $response;
    }

    /**
     * Apply manual filter
     * @param Callable $filter Filter function to apply
     */
    public function filter(Callable $filter): Dataset{
        return new Self(array_values(array_filter($this->data, $filter)), $this->record);
    }

    /**
     * Magic call function
     * This is used to filter the dataset
     * @param String $func Function that was called
     * @param Array $args Arguments for the call
     */
    public function __call(String $func, Array $args){
        // check if string starts with for or and
        if(str_starts_with($func, 'for') || str_starts_with($func, 'and')){
            // now we can extact the property
            $property = lcfirst(substr($func, 3));
            // check if property exists
            if(!array_key_exists($property, $this->record)){	
                throw new Exception('Call to undefined method '.get_called_class().'::'.$func.'()');
            }
            // return new dataset with filtered records
            return new Self(array_values(array_filter($this->data, 
                function($record) use($property, $args){
                    return call_user_func(array($record, 'get'.ucfirst($property))) == current($args);
                })), $this->record);
        }
        // check if func end with contains
        else if(str_ends_with($func, 'Contains')){
            // now we can extact the property
            $property = lcfirst(substr($func, 0, strlen($func)-8));
            // check if property exists
            if(!array_key_exists($property, $this->record)){	
                throw new Exception('Call to undefined method '.get_called_class().'::'.$func.'()');
            }
            // return new dataset with filtered records
            return new Self(array_values(array_filter($this->data, 
                function($record) use($property, $args){
                    return strstr(call_user_func(array($record, 'get'.ucfirst($property))), current($args));
                })), $this->record);
        }
        // thow exception if there is no match
        throw new Exception('Call to undefined method '.get_called_class().'::'.$func.'()');
        
    }

}