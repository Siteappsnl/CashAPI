<?php
/**
 * CashWeb API - Ledger Mutations Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\LedgerMutation;

use DateTime;

/**
 * Ledger Mutations Logic
 */
class LedgerMutations extends AbstractLogic{

    /**
     * Fetch mutations inside a month
     * NOTE: For large administrations this could take up a lot of memory!
     * @param Int $year Lookup for this year
     * @param Int $month Lookup for this month
     * @param Int $untillYear Lookup untill this year
     * @param Int $untillMonth Lookup untill this month
     * @return Dataset
     */
    public function fetchMutations(Int $year, Int $month, ?Int $untillYear = NULL, ?Int $untillMonth = NULL): Dataset{
        // create the from date object
        $from = (new DateTime())
            ->setDate($year, $month, 1)
            ->format('ym');

        // create the untill date object
        $untill = (new DateTime())
            ->setDate($untillYear ? $untillYear : $year, $untillMonth ? $untillMonth : $month, 1)
            ->format('ym');
        
        // fetch the mutations
        $response = $this->getConnection()
            ->export('0301T', array($from, $untill));

        // deassemble the array
        return (new LedgerMutation())
            ->createDataset($response);
    }

    /**
     * Import mutations
     * @param Array $mutations Array of mutations to import
     */
    public function importMutations(Array $mutations){
        $this->importArray($mutations);
    }

    /**
     * Fetch the next secquence identifier
     * @param String $journal Journal to fetch the next sequence number for
     * @param Int $year Yeat for this number
     * @return Int
     */
    public function fetchNextSequenceId(String $journal, ?Int $year = NULL){
        // create the year variable
        $year = (new DateTime())
            ->setDate($year ? $year : date('Y'), 1, 1)
            ->format('y');
        
        // request the next entry number
        $response = $this->getConnection()
            ->export('8504', array($year, $journal));

        // return the next sequence number
        return $response['R8504']['Z0303'];
    }

}
?>