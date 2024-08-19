<?php
/**
 * CashWeb API - Ledger Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Ledger record
 */
class Ledger extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0201';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'ledgerId' => array('0201', 'S6*'),
        'searchName' => array('0202', 'S10'),
        'description' => array('0203', 'L30*')
    );

}
?>