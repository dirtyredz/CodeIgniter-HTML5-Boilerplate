<?php

/**
 * MySecurity short summary.
 *
 * MySecurity description.
 *
 * @version 1.0
 * @author Dirtyredz
 */
class MySecurity
{
    
    protected $CI;
    
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        //$this->CI =& get_instance();
    }
    
    /**
     * ValidateFirstName
     * 
     * Pregmatch on a first name
     * a-z, A_Z, more then 3 char longer.
     * strict mode dissallows spaces and special charecters like hyphens
     * 
     * @param string $FirstName 
     * @param bool Strict = true
     * @return bool
     */
    public function ValidateFirstName($FirstName, $Strict = true){
        if($Strict === true){
            if(preg_match('/^[a-zA-Z]{3,}$/', $FirstName)) {
                return true;
            }
        }elseif($Strict === false){
            if(preg_match("/^[\p{L} '-]+$/", $FirstName)) {
                return true;
            }
        }
        return false;
    }

    /**
     * ValidateLastName
     * 
     * Pregmatch on LastName
     * @param string $LastName 
     * @return bool
     */
    public function ValidateLastName($LastName){
        if(preg_match("/^[\p{L} '-]+$/", $LastName)) {
            return true;
        }
        return false;
    }

    /**
     * ValidateStandard
     * 
     * Pregmatch on standard
     * @param string $Standard 
     * @return bool
     */
    public function ValidateStandard($Standard){
        if(preg_match("/^[\p{L} '-]+$/", $Standard)) {
            return true;
        }
        return false;
    }

    /**
     * Summary of ValidateZipcode
     * @param mixed $Zip 
     * @return bool
     */
    public function ValidateZipcode($Zip){
        if(preg_match('/^[0-9]{5}([- ]?[0-9]{4})?$/', $Zip)) {
            return true;
        }
        return false;
    }

    /**
     * Summary of ValidatePhone
     * @param string $Phone 
     * @return bool
     */
    public function ValidatePhone($Phone){
        if(preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $Phone)) {
            return true;
        }
        return false;
    }

    /**
     * Summary of CheckEmpty
     * @param mixed $Data 
     * @return bool
     */
    public function CheckEmpty($Data){
        if($Data === NULL || $Data === ''){
            return false;
        }
        return true;
    }
    
    /**
     * encodeEmailAddress
     * 
     * URLEncodes an Email address.
     * 
     * @param String $email 
     * @return string
     */
    public function encodeEmailAddress( $email ) {
        $output = '';
        for ($i = 0; $i < strlen($email); $i++){
            $output .= '&#'.ord($email[$i]).';';
        }
        return $output;
    }
    
    /**
     * ValidateEmail
     *
     * Verifies if provided Email is not null & is not empty.
     * Will set_flashdata('EmailError') if unseccussful.
     * @param string $email Email as string
     * @return $row
     * @return $row
     */
    public function ValidateEmail($email, $strict = true){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function ValidatePassword($password, $username = false) {

        $length = strlen($password);
        
        if ($length < 8) {
            return 'Password too short!';
        }

        preg_match_all ("/(.)\1{2}/", $password, $matches);
        $consecutives = count($matches[0]);
        
        preg_match_all ("/\d/i", $password, $matches);
        $numbers = count($matches[0]);
        
        preg_match_all ("/[A-Z]/", $password, $matches);
        $uppers = count($matches[0]);
        
        preg_match_all ("/[^A-z0-9]/", $password, $matches);
        $others = count($matches[0]);

        if ($uppers < 1) {
            return 'Not enough upper case letters';
        }
        if ($consecutives > 1) {
            return 'Cannot have consectutive numbers';
        }
        if ($numbers < 1) {
            return 'Not enough numbers';
        }
        if ($others < 1) {
            return 'Not enough Special Charecters';
        }
        return true;
    }

    public function IsStateAbbrev($Abbr){
        $states = array('AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut',
            'DE'=>'Delaware','DC'=>'District of Columbia','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa',
            'KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota',
            'MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico',
            'NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island',
            'SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington',
            'WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming',);
        return array_key_exists($Abbr, $states);
    }

    public function isNumber($integer,$minRange = 0,$maxRange = PHP_INT_MAX){
        $options = array(
            'options' => array(
                'default' => FALSE,
                'min_range' => $minRange,
                'max_range' => $maxRange,
            )
        );

        if (filter_var($integer, FILTER_VALIDATE_FLOAT,$options))
                return true;
        return false;
    }

    public function is_timestamp($timestamp)
    {
        $check = (is_int($timestamp) OR is_float($timestamp))
            ? $timestamp
            : (string) (int) $timestamp;
        return  ($check === $timestamp)
                AND ( (int) $timestamp <=  PHP_INT_MAX)
                AND ( (int) $timestamp >= ~PHP_INT_MAX);
    }

    /**
     * Test if String is a float
     * 
     * @param string $Value 
     * @param int $Decimal 
     * @return bool
     */
    public function is_float($Value,$Decimal = 0) {

        if(strlen(substr(strrchr($Value, "."), 1)) > 2){return false;}
        if(strlen(substr(strstr($Value, ".",true), 0)) > 1){return false;}
        if (!is_scalar($Value)) {return false;}

        $type = gettype($Value);

        if ($type === "float") {
            return true;
        } else {
            return preg_match("/^\\d+\\.\\d+$/", $Value) === 1;
        }

    }


}
