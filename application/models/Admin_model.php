<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }    

    public function signin($username, $password) {
        
        include("/var/www/cloudcode.php");

        if ($username == $admin['username'] && $password == $admin['password']) {
            return array("username" => "admin");
        } else {
            return null;
        }
    }

}
