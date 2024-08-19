<?php
/**
 * CashWeb API - Administration Record
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb\Records;

/**
 * Administartion record
 */
class Administration extends AbstractRecord{

    /** @var String $code Administration code */
    private String $code;

    /** @var String $name Administration name */
    private String $name;

    /**
     * Class Contructor
     * Fills the administration details
     * @param String $code Administration code
     * @param String $name Administration name
     */
    public function __construct(String $code, String $name){
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * Get the code for the administration
     * @return String
     */
    public function getCode(): String{
        return $this->code;
    }

    /**
     * Get the name of the administration
     * @return String
     */
    public function getName(): String{
        return $this->name;
    }

    /**
     * Convert the administration to array
     * @return Array
     */
    public function toArray(): Array{
        return array(
            'code' => $this->code,
            'name' => $this->name
        );
    }

}
?>