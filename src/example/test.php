<?php
if ($argc != 3){
	die("usage: php test.php LOGIN PASSWORD\n\n");
}

require_once ('../client.php');

Client::init();

$msn = new Hellow_Protocol_Msnp8;
$msn->login ($argv[1], $argv[2]);





