<?php
/**
 * CashWeb API - Cost Cenrers Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\CostCenter;

/**
 * Cost Centers Logic
 */
class CostCenters extends AbstractLogic{

    /**
     * Fetch cost center list
     */
    public function fetchCostCenters(): Dataset{
        // fetch the cost centers
        $response = $this->getConnection()
            ->export('0911T');

        // deassemble the array
        return (new CostCenter())
            ->createDataset($response);
    }

    /**
     * Save a cost center object
     * @param CostCenter $costCenter Cost Center to save
     */
    public function saveJournal(CostCenter $costCenter){
        $this->importRecord($costCenter);
    }

}
?>