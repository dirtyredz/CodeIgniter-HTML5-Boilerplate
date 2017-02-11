<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $UserData = null;
    public $Debug = true;

    function __construct(){
		parent::__construct();
    date_default_timezone_set('America/Detroit');
    error_reporting(E_ALL);
		$this->load->helper('url');
    $this->load->helper('form');
	}
}
