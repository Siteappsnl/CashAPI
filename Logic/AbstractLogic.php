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
        // Prepare the chash import array
        $cash = array(); foreach($array as $record){
            if(!is_a('CashWeb\Records\AbstractRecord', $record)){
                throw new CashWebException('Record is not a valid CashWeb Record.');
            }
            array_push($cash, $record->assemble());
        }
        // Import the data
        $this->getConnection()->import($cash);
    }

}
?>