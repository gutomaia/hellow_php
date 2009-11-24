<?php
abstract class Hellow_Protocol_Switchboard extends Hellow_Protocol_Msnp {
	const WIN_MOBILE = 0x01;
	const EXPLORER_8 = 0x02;
	const INK_GIF = 0x04;
	const INK_ISF = 0x08;
	const WEBCAM = 0x10;
	const MULTIPLAK=0x20;	
	const DIRECTIM = 0x4000;
	const WINKS = 0x8000;
	const SIP = 0x100000;
	const SHARINGFOLDER = 0x400000;
	const MSNC1 = 0x10000000; //Msn Msgr 6.0
	const MSNC2 = 0x20000000; //Msn Msgr 6.1
	const MSNC3 = 0x30000000; //Msn Msgr 6.2
	const MSNC4 = 0x40000000; //Msn Msgr 7.1
	const MSNC5 = 0x50000000; //Msn Msgr 7.5
	const MSNC6 = 0x60000000; //Msn Msgr 8.0
	const MSNC7 = 0x70000000; //Msn Msgr 8.1
	const MSNC8 = 0x70000000; //Msn Msgr 8.5

	private $_host;
	private $_port;
		
	public function getHost(){
		return $this->_host;
		
	}
	
	public function getPort(){
		return $this->_port;
	}
	
	protected function connect($host, $port) {
		$this->_host = $host;
		$this->_port = $port;
		$this->_connectionHandle->connect($host, $port);
	}
}
