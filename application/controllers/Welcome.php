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
        $this->data['current'] = "Home";
        $this->load->view('index',$this->data);
	}


  public function GenerateCaptcha(){
      $this->load->library('image_lib');
      $this->load->helper('captcha');
      $random_number = substr(number_format(time() * rand(),0,'',''),0,6);
      $vals = array(
          'word' => $random_number,
          'img_path'      => FCPATH.'captcha/',
          'img_url'       =>  base_url().'captcha/',
          'font_path'     => FCPATH.'Fonts/texb.ttf',
          'img_width'     => '165',
          'img_height'    => 30,
          'colors'        => array(
                  'background' => array(255, 255, 255),
                  'border' => 'none',
                  'text' => array(0, 0, 0),
                  'grid' => array(255, 40, 40)
          )
      );
      $cap = create_captcha($vals);
      if($this->Main_model->AddCaptcha(time(),$cap['word'],$this->input->ip_address())){
        $this->data['captchaImg'] = $cap['image'];
      }else{
        $this->data['captchaImg'] = "Error";
      };

  }
}
