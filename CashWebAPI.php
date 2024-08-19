<?php
/**
 * CashWeb API - API Connection
 * 
 * @package CashWeb
 * @author R. Kock <rick.kock@siteapps.nl>
 * @copyright Copyright (c) 2024 Siteapps
 * @version 1.0
 */

namespace CashWeb;

use CashWeb\Records\Administration;
use ReflectionClass;
use Exception;

/** Cash Web API Implementation */
class CashWebAPI{

    /** @var String $endpointUrl Endpoint URL */
    private String $endpointUrl = 'https://www.cashweb.nl/api/4.0';

    /** @var String $apiKey API Key reference */
    private String $apiKey = '';

    /** @var String $administration administration code */
    private ?String $administration = '';

    /**
     * Initialize the Cash API
     * @param String $apiKey API Key For the REST API
     * @param String $administration Administration to use
     */
    public function __construct(String $apiKey, ?String $administration = NULL){
        $this->apiKey = $apiKey;
        $this->administration = $administration;

        // Create the auto load register function
        spl_autoload_register(function($class){
            if(str_starts_with($class, 'CashWeb')){
                // define the class path
                $classPath = dirname(__FILE__).'/'.str_replace('\\', DIRECTORY_SEPARATOR, substr($class, 8)).'.php';
                // check if class file exists
                if(is_file($classPath)){
                    // require the class path file
                    require_once($classPath);
                    return true;
                }
            }
            return false;
        });
    }

    /**
     * Fetch a list of administartions
     * @return 
     */
    public function fetchAdministrations(){
        // fetch the administrations
        $administrations = $this->executeRequest('GET', '/administrations');
        // create dataset array
        $dataset = array();
        // loop through the administrations
        foreach($administrations['Dir'][0]['Adms']['Adm'] as $administration){
            array_push($dataset, new Administration($administration['Code'], $administration['Name']));
        };
        // Return the dataset
        return new Dataset($dataset, array());
    }

    /**
     * Export data from the cash API
     * @param String $record Record to export
     * @param Array $params Parameter array
     */
    public function export(String $record, Array $params = array()){
        return $this->executeRequest('EXPORT', '/get/index/'.$record.'/?'.
            http_build_query(array('admin' => $this->administration, 'params' => implode('|', $params))));
    }

    /**
     * Import data
     * @param Array $data Data to import
     */
    public function import(Array $data){
        return $this->executeRequest('IMPORT', '/import', array(
            'admin' => $this->administration,
            'format' => 0,
            'content' => array(
                'cash' => $data
            )
        ));
    }

    /**
     * Execute Cash Request
     * @param String $requestType Request Type
     * @param String $endpoint Endpoint to request
     * @param Array $data Data for the request
     */
    public function executeRequest(String $requestType, String $endpoint, Array $data = array()){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $this->endpointUrl.$endpoint);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 
            array( 
				'Accept: application/json', 
                'Cache-Control: no-cache', 
                'Sec-Fetch-Mode: cors', 
                'Authorization: '.$this->apiKey,
                'Content-Type: application/json'
            ));
        
        // for info attach the data to the POST
		if($requestType == 'IMPORT'){
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
		}
        // execute the request and fetch the response
		$responseText = curl_exec($curl);
        // decode the response
        $responseDecoded = json_decode($responseText, true);
        // extract the httpcode
		$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		// Close the connection
        curl_close($curl);
        // check if valid JSOn could be parsed
        if(json_last_error() !== JSON_ERROR_NONE){
            throw new CashWebException('Could not parse CashWeb response.');
        }
        // Check if status is not 200
        if($httpCode !== 200){
            throw new CashWebException($responseDecoded['message'] ? $responseDecoded['message'] : 'Unkown CashWeb API Response.');
        }
        // return the decoded response
        return $responseDecoded;
    }

    /**
     * Magic call function
     * This is used to filter the dataset
     * @param String $func Function that was called
     * @param Array $args Arguments for the call
     */
    public function __call(String $func, Array $args){
        // Construct the classname
        $className = 'CashWeb\\Logic\\'.ucfirst($func);
        // Check if class exists
        if(class_exists($className)){
            return (new ReflectionClass($className))
                ->newInstance($this);
        }
        // thow exception if there is no match
        throw new Exception('Call to undefined method '.get_called_class().'::'.$func.'()');
    }

}