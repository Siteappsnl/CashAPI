<?php
/**
 * CashWeb API - Ledger Mutation Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Ledger mutation record
 */
class LedgerMutation extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0301';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'period' => array('0301', 'Y4'),
        'date' => array('0302', 'D'),
        'journalId' => array('0901', 'S6*'),
        'sequenceId' => array('0303', 'N6*'),
        'ledgerId' => array('0201', 'S6*'),
        'costCenterId' => array('0911', 'S3'),
        'relationId' => array('0101', 'N6'),
        'invoiceNumber' => array('0309', 'N6'),
        'quantity' => array('0305', 'I12,2*'),
        'description' => array('0306', 'L25'),
        'amount' => array('0307', 'I12,2*'),
        'reference' => array('0711', 'S13'),
    );


    
}
?>