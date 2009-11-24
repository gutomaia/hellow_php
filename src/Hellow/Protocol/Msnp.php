<?php
abstract class Hellow_Protocol_Msnp {

	var $EL = "\r\n";

	protected $_trid = 1;

	protected $_passport = null;

	private $_connection;

	private $_connectionHandle;

	public function __construct () {
		$this->_connectionHandle = new Hellow_Core_SocketConnection;
	}

	public function setConnectionHandle($connectionHandle){
		$this->_connectionHandle = $connectionHandle;
	}

	private $_commandListener = null;

	public final function addCommandListener($commandListener){
		$this->_commandListener = $commandListener;
	}

	protected final function onCommandReceived($command){if(!empty($this->_commandListener)) $this->_commandListener->onCommandReceived($command);}
	protected final function onCommandSended($command){if(!empty($this->_commandListener)) $this->_commandListener->onCommandSended($command);}

	abstract function getHost();
	abstract function getPort();
	abstract function execute($command);

	protected final function send($cmd) {
		$this->_connectionHandle->send($cmd);
		$this->onCommandSended($cmd);
		$this->_trid++;
	}

	protected function connect($host, $port) {
		$this->_connectionHandle->connect($host, $port);
	}

	protected function disconnect() {
		$this->_connectionHandle->disconnect();
	}

	protected final function listen() {
		$cont = true;
		while ($cont) {
			$command = $this->_connectionHandle->nextCommand();
			if (trim($command) != "") {
				$this->execute($command);
				$this->onCommandReceived($command);
			}
		}
		$this->logout();
	}
}
