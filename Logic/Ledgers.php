<?php
/**
 * CashWeb API - Ledger Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\Ledger;

/**
 * Ledgers Logic
 */
class Ledgers extends AbstractLogic{

    /**
     * Fetch ledgers list
     */
    public function fetchLedgers(): Dataset{
        // fetch the ledgers
        $response = $this->getConnection()
            ->export('0201T');

        // deassemble the array
        return (new Ledger())
            ->createDataset($response);
    }

    /**
     * Save a legder object
     * @param Ledger $ledger Ledger to save
     */
    public function saveLedger(Ledger $ledger){
        $this->importRecord($ledger);
    }

}
?>