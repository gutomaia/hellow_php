<?php

class MockConnection implements Hellow_Core_ConnectionHandle {
	
	public $sended = null;
	public $received = null;
	public $host;
	public $port;
	
	function connect($host, $port) {
		$this->host = $host;
		$this->port = $port;
	}

	function disconnect() {
	}

	public function send($cmd) {
		$this->sended = $cmd;
	}

	public function receive($cmd) {
		$this->received = $cmd;
	}

	function nextCommand() {
		return null;
	}

}
