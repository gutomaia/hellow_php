<?php

require __DIR__.'/../vendor/autoload.php';

if ($argc != 3){
	die("usage: php test.php LOGIN PASSWORD\n\n");
}

$msn = new \Hellow\Protocol\Msnp8;
$msn->login($argv[1], $argv[2]);
