<?php
echo $argc;
var_dump($argv);
if ($argc != 3){
	die("usage: php test.php LOGIN PASSWORD\n\n");
}

require_once ('../client.php');

Client::init();

$msn = new Hellow_Protocol_Msnp8;
//$socket = new Hellow_Core_SocketConnection;
//$msn->setConnectionHandle($socket);
$msn->login ($argv[1], $argv[2]);





