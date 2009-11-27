<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowAs and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

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

	function hasMoreCommands(){
		return false;
	}

}
