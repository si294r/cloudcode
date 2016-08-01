<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Parse_prod extends CI_Controller {

    var $key = "parse_prod";
    var $key2 = "parse_prod2";
    var $docker = "parse_prod";
    var $filename = "main_prod.js";
    
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['signin'])) {
            redirect('signin');
        }
    }

    public function index() {
        $this->load->view('parse_view');
    }
    
    public function get_source() {
        $this->load->model('cloudcode_model', 'cloudcode');
        echo $this->cloudcode->get_source($this->key, $this->filename);
    }
    
    public function set_source() {
        $source = file_get_contents("php://input");
        file_put_contents("/var/www/html/cloudcode/temp/{$this->filename}", $source);
        
        $this->load->model('cloudcode_model', 'cloudcode');
        $out = $this->cloudcode->set_source($this->key, $this->docker, $this->filename);
        $out2 = $this->cloudcode->set_source($this->key2, $this->docker, $this->filename);
        
        echo $out;
        echo "\r\n";
        echo $out2;
    }

}
