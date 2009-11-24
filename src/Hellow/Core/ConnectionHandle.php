<?php
interface Hellow_Core_ConnectionHandle {
	function connect($host, $port);
	function disconnect();
	function nextCommand();
	function hasMoreCommands();
	function send($cmd);
}
