<?php
/**
 * CashWeb API - Mandate Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Mandate Record
 */
class Mandate extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0109';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'relationId' => array('0101', 'S6*'),
        'iban' => array('0110', 'S10'),
        'bic' => array('0350', 'L35*')
    );

}
?>