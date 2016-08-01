<?php

include("/var/www/cloudcode.php");

function exec_command($config, $command) {
    $connection = ssh2_connect($config['host'], $config['port']);
    ssh2_auth_password($connection, $config['username'], $config['password']);

    $stream = ssh2_exec($connection, $command);

    stream_set_blocking($stream, true);

    $out = stream_get_contents($stream);

    fclose($stream);
    
    return $out;
}

/*  
 *  Export docker container and copy to server destination :
 *      docker export -o parse_prod.tar parse_prod  
 *      scp parse_prod.tar root@alegrium5.alegrium.com:/root
 * 
 *  Import docker and run :
 *      docker import parse_prod.tar parse_prod
 *      docker run -i -t --net=host --name parse_prod parse_prod /bin/bash
 *      docker exec parse_prod pm2 start /root/ecosystem.json
 * 
 *  Upload new cloud code and restart pm2 :
 *      docker cp /root/main_prod.js parse_prod:/root/
 *      docker exec parse_prod pm2 restart all
 *  */
$out = exec_command($server[0], 'docker exec parse pm2 restart all');



echo "<pre>" . $out . "</pre>";
