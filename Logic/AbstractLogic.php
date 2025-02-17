<?php
/**
 * CashWeb API Abstract Logic function
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\CashWebAPI;
use CashWeb\CashWebException;
use CashWeb\Records\AbstractRecord;

/**
 * Abstract Logic Implementation
 */
class AbstractLogic{

    /** @var ?CashWebAPI $connection CashWebConnection API */
    private ?CashWebAPI $connection; 

    /**
     * Initialize the class
     * Stored the API Connection
     */
    public function __construct(CashWebAPI $connection){
        $this->connection = $connection;
    }

    /**
     * Get the Connection
     * @rteurn CashWebAPI
     */
    public function getConnection(): CashWebAPI{
        return $this->connection;
    }

    /**
     * Import Abstract record
     * @param AbstractRecord $record Abstract record to import
     */
    protected function importRecord(AbstractRecord $record){
        $this->importArray(array($record));
    }

    /**
     * Import Array of abstract records
     * @param Array $array Array of abstact records to import
     */
    protected function importArray(Array $array){
        // Import the data
        $this->getConnection()->import(self::assemble($array));
    }

    /**
     * Assemble a array of data entries
     * @param Array $array Array of abstact records to assemble
     * @return Array
     */
    public static function assemble(Array $array): Array{
        // Prepare the chash import array
        $cash = array(); foreach($array as $record){
            if(!is_a($record, 'CashWeb\Records\AbstractRecord')){
                throw new CashWebException('Record is not a valid CashWeb Record.');
            }
            array_push($cash, $record->assemble());
        }
        return $cash;
    }

    /**
     * Assemble a array of data entries
     * @param Array $array Array of abstact records to assemble
     * @return Array
     */
    public static function toArray(Array $array): Array{
        // Prepare the chash import array
        $cash = array(); foreach($array as $record){
            if(!is_a($record, 'CashWeb\Records\AbstractRecord')){
                throw new CashWebException('Record is not a valid CashWeb Record.');
            }
            array_push($cash, $record->toArray());
        }
        return $cash;
    }

}
?>