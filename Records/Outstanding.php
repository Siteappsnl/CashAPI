<?php
/**
 * CashWeb API - Outstanding Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Outstanding Record
 */
class Outstanding extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0311';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'period' => array('0301', 'Y4'),
        'date' => array('0302', 'D6*'),
        'journalId' => array('0901', 'S6*'),
        'sequenceId' => array('0303', 'N6*'),
        'ledgerId' => array('0201', 'S6*'),
        'relationId' => array('0101', 'S6*'),
        'relation' => array('0103', 'L35'),
        'invoiceNumber' => array('0309', 'N6'),
        'invoiceDate' => array('0314', 'D'),
        'amount' => array('0307', 'I12,2'),
        'amountOutstaning' => array('0320', 'I12,2'),
        'expirationDate' => array('0111', 'D')
    );

}
?>