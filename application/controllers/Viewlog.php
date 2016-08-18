<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Viewlog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['signin'])) {
            redirect('signin');
        }
    }

    public function index($class) {
        $this->load->view('viewlog_view', array('class' => $class));
    }

    public function stream($class = "") {
        $this->load->model('viewlog_model', 'viewlog');
        
        if ($class == "alegrium2") {
            $key = "alegrium2";
            $command = "docker exec php-fpm tail --lines=50 /var/log/apache2/access.log";
        } elseif ($class == "alegrium5") {
            $key = "alegrium5";
            $command = "docker exec php-fpm tail --lines=50 /var/log/apache2/access.log";
//            $command = "tail --lines=50 /var/log/apache2/access.log";
        } elseif ($class == "parse") {
            $key = "alegrium2";
            $command = "docker exec parse tail --lines=25 /root/.pm2/logs/parse-wrapper-error.log /root/.pm2/logs/parse-wrapper-out.log";                        
        } elseif ($class == "parse2") {
            $key = "alegrium2";
            $command = "docker exec parse2 tail --lines=25 /root/.pm2/logs/parse-wrapper2-error.log /root/.pm2/logs/parse-wrapper2-out.log";                        
        } elseif ($class == "parse_prod") {
            $key = "alegrium2";
            $command = "docker exec parse_prod tail --lines=25 /root/.pm2/logs/parse-production-error.log /root/.pm2/logs/parse-production-out.log";                        
        } elseif ($class == "parse_prod2") {
            $key = "alegrium5";
            $command = "docker exec parse_prod tail --lines=25 /root/.pm2/logs/parse-production-error.log /root/.pm2/logs/parse-production-out.log";                        
        } else {
            $key = "";
            $command = "";
        }
        
        if ($key != "" && $command != "") {
            echo $this->viewlog->stream($key, $command);
        } else {
            echo "Service Unavailable";
        }
    }

}
