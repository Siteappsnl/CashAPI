<?php
/**
 * CashWeb API - Journal Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Journal record
 */
class Journal extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0901';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'journalId' => array('0901', 'S6*'),
        'description' => array('0902', 'L30*')
    );

}
?>