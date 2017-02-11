<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @author David McClain
 */
class Main_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    public function CheckCaptchaTable(){
      $DB = $this->load->database(DBNAME,true);
      if (!$DB->table_exists('captcha'))
      {
        $this->myforge = $this->load->dbforge($DB, TRUE);
        $fields = array(
          'captcha_id' => array(
                  'type' => 'BIGINT',
                  'constraint' => 13,
                  'unsigned' => TRUE,
                  'auto_increment' => TRUE,
                  'null' => FALSE
          ),
          'captcha_time' => array(
                  'type' => 'INT',
                  'constraint' => 10,
                  'unsigned' => TRUE,
                  'null' => FALSE
          ),
          'ip_address' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 45,
                  'unsigned' => FALSE,
                  'null' => FALSE
          ),
          'captcha_word' => array(
                  'type' => 'VARCHAR',
                  'constraint' => 20,
                  'unsigned' => FALSE,
                  'null' => FALSE
          )
        );
        $this->myforge->add_field($fields);
        $this->myforge->add_key('captcha_id', TRUE);
        $this->myforge->create_table('captcha');
      }
      return true;
    }

    public function AddCaptcha($Time,$Word,$IP){
        $this->CheckCaptchaTable();
        if(!empty($Time) && !empty($Word) && !empty($IP)){
          $DB = $this->load->database(DBNAME,true);
          $sql = 'INSERT INTO captcha (captcha_time, ip_address, captcha_word) VALUES (?, ?, ?)';
          $DB->query($sql, array($Time,$IP, $Word));
          return true;
        }
        return false;
    }

    public function CheckCaptcha(){
        $DB = $this->load->database(DBNAME,true);
        $expiration = time() - 7200;
        $sql = 'DELETE FROM captcha WHERE captcha_time < '.$expiration;
        $DB->query($sql);

        $captcha = $this->input->post('captcha',true);//Standard XSS cleaning
        // Then see if a captcha exists:
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE captcha_word = ? AND ip_address = ?';
        $query = $DB->query($sql, array($captcha,$this->input->ip_address()));
        if ($query->row()->count == 0){
            return false;
        }
        return true;
    }
}
