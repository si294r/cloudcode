<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class cloudcode_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_source($key, $filename) {
        
        include("/var/www/cloudcode.php");
        $config = $server[$key];
        
        $connection = ssh2_connect($config['host'], $config['port']);
        ssh2_auth_password($connection, $config['username'], $config['password']);

        $stream = ssh2_exec($connection, "cat /root/$filename");

        stream_set_blocking($stream, true);

        $out = stream_get_contents($stream);

        fclose($stream);

        return $out;
    }

    public function set_source($key, $docker, $filename) {
        
        include("/var/www/cloudcode.php");
        $config = $server[$key];
        
        $connection = ssh2_connect($config['host'], $config['port']);
        ssh2_auth_password($connection, $config['username'], $config['password']);

        ssh2_scp_send($connection, "/var/www/html/cloudcode/temp/$filename", "/root/$filename", 0644);
        ssh2_exec($connection, "docker cp /root/$filename $docker:/root/");
        $stream = ssh2_exec($connection, "docker exec $docker pm2 restart all");

        stream_set_blocking($stream, true);
        $out = stream_get_contents($stream);
        fclose($stream);

        return $out;
    }

}
