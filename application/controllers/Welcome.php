<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
    public $data;
    function __construct(){
        parent::__construct();
        $this->load->model('Main_model');
	}

    //Views
	public function index()
	{
        $this->data['current'] = "index";
        $this->load->view('index',$this->data);
	}
}
