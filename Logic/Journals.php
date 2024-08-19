<?php
/**
 * CashWeb API - Journals Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\Journal;

/**
 * Journals Logic
 */
class Journals extends AbstractLogic{

    /**
     * Fetch journals list
     */
    public function fetchJournals(): Dataset{
        // fetch the journals
        $response = $this->getConnection()
            ->export('0901T');

        // deassemble the array
        return (new Journal())
            ->createDataset($response);
    }

    /**
     * Save a journal object
     * @param Journal $journal Journal to save
     */
    public function saveJournal(Journal $journal){
        $this->importRecord($journal);
    }

}
?>