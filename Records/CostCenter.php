<?php
/**
 * CashWeb API - Cost Center Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Cost Center record
 */
class CostCenter extends AbstractRecord{

    /** @var String $recordIdentifier Record identifier */
    protected String $recordIdentifier = '0911';

    /** @var Array $record Record setup */
    protected Array $record = array(
        'costCenterId' => array('0911', 'S2*'),
        'description' => array('0912', 'L30*'),
        'blocked' => array('0208', 'S1'),
    );

}
?>