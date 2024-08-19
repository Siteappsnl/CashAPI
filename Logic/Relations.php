<?php
/**
 * CashWeb API - Relations Logic
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Logic;

use CashWeb\Dataset;
use CashWeb\Records\Mandate;
use CashWeb\Records\Relation;

/**
 * Relation Record
 */
class Relations extends AbstractLogic{

    /**
     * Fetch all relations stored in the current administation
     * @return Dataset
     */
    public function fetchRelations(): Dataset{
        // fetch the relations
        $response = $this->getConnection()
            ->export('0101T');

        // deassemble the array
        return (new Relation())
            ->createDataset($response);
    }

    /**
     * Fetch all mandates
     * @return Dataset
     */
    public function fetchMandates(): Dataset{
        // fetch the relations
        $response = $this->getConnection()
            ->export('0109T');

        // deassemble the array
        return (new Mandate())
            ->createDataset($response);
    }

    /**
     * Get next relation number
     * @param Bool $reserve Reserve the number
     * @return Int
     */
    public function getNextRelationNumber(Bool $reserve = false): Int{
        // fetch the number
        $response = $this->getConnection()
            ->export('2050'.($reserve ? 'R' : 'N'));
        // return the number
        return $response['R2050']['Z0101'];
    }

    /**
     * Save a relation object
     * @param Relation $relation Relation to save
     */
    public function saveRelation(Relation $relation){
        $this->importRecord($relation);
    }
    
}
?>