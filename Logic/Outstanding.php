<?php
/**
 * CashWeb API - Outstanding Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\Outstanding as OutstandingRecord;

/**
 * Outstanding Logic
 */
class Outstanding extends AbstractLogic{

    /**
     * Fetch cost center list
     */
    public function fetchOutstanding(): Dataset{
        // fetch the cost centers
        $response = $this->getConnection()
            ->export('0311T');
            
        // deassemble the array
        return (new OutstandingRecord())
            ->createDataset($response);
    }

}
?>