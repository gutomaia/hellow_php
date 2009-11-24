<?php
class Hellow_Core_SocketConnection implements Hellow_Core_ConnectionHandle{

	protected $_socket = null;

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
//			echo "<p style=\"color:#99cc00;\" >" . $cmd . "</p>";
			echo "\033[31m".$cmd;
		}
	}

	public function nextCommand() {
		if ($this->getSocket()) {
			$command = socket_read($this->getSocket(), 2048, PHP_NORMAL_READ);
			$cmd = substr($command, 0, 3);
			if ($cmd == 'MSG') {
				$command_aux = explode(' ', $command);
				$bytes = intval($command_aux[sizeof($command_aux) - 1]);
				$payload = socket_read($this->getSocket(), $bytes);
				$command .= $this->EL. $payload;
			} else {
				//$command = substr($command, 0, strlen($command) -1);
			}
			if ($command != "") {
				echo "\033[32m".$command;
				//echo "<p style=\"color:#ff0000;\" >" . $command . "</p>";
			}
		}
		return trim($command);
	}
}
