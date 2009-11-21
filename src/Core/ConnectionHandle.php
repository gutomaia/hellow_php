<?php
interface Core_ConnectionHandle {
	function connect($host, $port);
	function disconnect();
	function nextCommand();
	function send($cmd);
}
