<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

class Hellow_Core_SocketConnection implements Hellow_Core_ConnectionHandle{

	private $_socket = null;
	private $_buffer = "";

	private function getSocket() {
		if ($this->_socket < 0) {
			$this->disconnect();
		} else {
			return $this->_socket;
		}
	}

	public function connect($host, $port) {
		if ($this->getSocket()) {
			socket_close($this->_socket);
			$this->_socket == null;
		}
		$this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		$result = socket_connect($this->_socket, $host, $port);
	}

	public function disconnect() {
		if ($this->_socket) {
			socket_close($this->_socket);
			$this->_socket = null;
		} else {
			$this->_socket = null;
		}
	}

	public function send($cmd) {
		if ($this->getSocket()) {
			socket_write($this->getSocket(), $cmd, strlen($cmd));
			flush();
		}
	}

//TODO: fix payloads->http://www.hypothetic.org/docs/msn/resources/faq.php#howtoparse

	public function nextCommand() {
		if ($this->getSocket()) {
			$command = socket_read($this->getSocket(), 2048, PHP_NORMAL_READ);
			$cmd = substr($command, 0, 3);
			if ($cmd == 'MSG') {
				$command_aux = explode(' ', $command);
				$bytes = intval($command_aux[sizeof($command_aux) - 1]);
				$payload = socket_read($this->getSocket(), $bytes);
				$command .= $this->EL. $payload;
			}
		}
		return $command;
	}

	public function hasMoreCommands(){
		return true;
	}
}
