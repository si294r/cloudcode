<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class viewlog_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function stream($key, $command) {
        
        include("/var/www/cloudcode.php");
        $config = $server[$key];
        
        $connection = ssh2_connect($config['host'], $config['port']);
        ssh2_auth_password($connection, $config['username'], $config['password']);

        $stream = ssh2_exec($connection, $command);

        stream_set_blocking($stream, true);

        $out = stream_get_contents($stream);

        fclose($stream);

        return $out;
    }

}
