<?php
abstract class Hellow_Protocol_Msnp {

	var $EL = "\r\n";

	protected $_trid = 1;

	protected $_passport = null;

	private $_connection;

	private $_connectionHandle;

	public function __construct () {
		$this->_connectionHandle = new SocketConnection();
	}

	public function setConnectionHandle($connectionHandle){
		$this->_connectionHandle = $connectionHandle;
	}

	abstract function getHost();
	abstract function getPort();
	abstract function execute($command);

	protected final function send($cmd) {
		$this->_connectionHandle->send($cmd);
		$this->_trid++;
	}

	protected function connect($host, $port) {
		$this->_connectionHandle->connect($host, $port);
	}

	protected function disconnect() {
		$this->_connectionHandle->disconnect();
	}

	protected function listen() {
		$i = 0;
		$cont = true;
		while ($cont) {
			$command = $this->_connectionHandle->nextCommand();
			if (!empty ($command)) {
				$this->execute($command);
			}
			//if ($endtime - $initime > 30) {
			//	$cont = false;
			//}
			//if (!$this->getSocket()) {
			//	$cont = false;
			//}
			$cont = false;
			if ($i > 150){
				$cont = false;
			}
			$i++;
		}
		$this->logout();
	}
	
	protected function listen2() {
		$i = 0;
		if ($this->getSocket()){
			for ($cmd = $this->nextCommand(); !empty($cmd);$cmd = $this->nextCommand(), $i++){
				$tokens = explode(" ", $cmd);
				$this->execute($tokens[0], $tokens);
				flush();
				if (!$this->getSocket()) {
					return false;
				}
				echo $i;
				if ($i == 100){
					echo 'loop no listen 2';
					break;
				}
			}
			return true;
		}
		return false;
	}
}
