<?php
/**
 * CashWeb API - Relation Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Relation Record
 */
class Relation extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0101';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'relationId' => array('0101', 'S6*'),
        'searchName' => array('0102', 'S10'),
        'name' => array('0103', 'L35*')
    );

}
?>