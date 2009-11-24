<?php

require '../src/client.php';


class ProtocolTest extends PHPUnit_Framework_TestCase {

	private $_msn;
	private $_mockAuth;
	private $_mockConnection;
	private $_receivedMessage = null;

	private function receive($msg){
		$this->_received = $msg;
	}


	private function send($msg){
		if ($this->_received != null){
			$this->_msn->execute($this->_received);
		}
	}

	private function sendAndComfirm($msg) {
		if ($this->_received != null){
			$this->_msn->execute($this->_received);
		}
		$this->assertEquals($msg, $this->_mockConnection->sended, "Send command is invalid");
	}

	public function setup(){
		Client::init();
		require_once './MockAuthentication.php';
		require_once './MockConnection.php';
		$this->_mockAuth = new MockAuthentication;
		$this->_mockConnection = new MockConnection;
		$this->_msn = new Hellow_Protocol_Msnp8();
		$this->_msn->setAuthenticationHandle($this->_mockAuth);
		$this->_msn->setConnectionHandle($this->_mockConnection);
		$this->_msn->login("dvader@empire.com", "ih8jedis");
	}

	public function testChallenger(){
		$chl = "29409134351025259292";
		$digest = $this->_msn->challenger($chl);
		$this->assertEquals("d0c1178c689350104350d99f8c36ed9c", $digest);
	}

	public function testSession(){
		//Sends the MSN Client version
		$this->send("VER 1 MSNP8 CVR0\r\n");
		//acknolodge

		$this->receive("VER 1 MSNP8 CVR0\r\n");
		$this->sendAndComfirm("CVR 2 0x0409 win 4.10 i386 MSNMSGR 6.0.0602 MSMSGS dvader@empire.com\r\n");
		
		//Client sends information

		$this->receive("CVR 2 6.0.0602 1.0.000 http://download.microsoft.com/download/8/a/4/");
		$this->sendAndComfirm("USR 3 TWN I dvader@empire.com\r\n");

		//Redirect
		$this->receive("XFR 3 NS 207.46.106.118:1863 0 207.46.104.20:1863\r\n");
		$this->sendAndComfirm("VER 4 MSNP8 CVR0\r\n");
		$this->assertEquals("207.46.106.118",$this->_mockConnection->host, "Host não foi alterado");
		$this->assertEquals("1863",$this->_mockConnection->port, "Port não foi alterada");


		$this->receive("VER 4 MSNP8 CVR0\r\n");
		$this->sendAndComfirm("CVR 5 0x0409 win 4.10 i386 MSNMSGR 6.0.0602 MSMSGS dvader@empire.com\r\n");

		$this->receive("CVR 5 6.0.0602 6.0.0602 1.0.0000 http://download.microsoft.com/download/8/a/4/8a42bcae-f533-4468-b871-d2bc8dd32e9e/SETUP9x.EXE http://messenger.msn.com\r\n");
		$this->sendAndComfirm("USR 6 TWN I dvader@empire.com\r\n");

		
		$this->receive("USR 6 TWN S lc=1033,id=507,tw=40,fs=1,ru=http%3A%2F%2Fmessenger%2Emsn%2Ecom,ct=1062764229,kpp=1,kv=5,ver=2.1.0173.1,tpf=43f8a4c8ed940c04e3740be46c4d1619\r\n");
		$this->sendAndComfirm("USR 7 TWN S t=53*1hAu8ADuD3TEwdXoOMi08sD*2!cMrntTwVMTjoB3p6stWTqzbkKZPVQzA5NOt19SLI60PY!b8K4YhC!Ooo5ug$$&p=5eKBBC!yBH6ex5mftp!a9DrSb0B3hU8aqAWpaPn07iCGBw5akemiWSd7t2ot!okPvIR!Wqk!MKvi1IMpxfhkao9wpxlMWYAZ!DqRfACmyQGG112Bp9xrk04!BVBUa9*H9mJLoWw39m63YQRE1yHnYNv08nyz43D3OnMcaCoeSaEHVM7LpR*LWDme29qq2X3j8N\r\n");

		$this->receive("USR 7 OK dvader@empire.com Dart%20Vader 1 0\r\n");
		$this->sendAndComfirm("SYN 1 0\r\n");

		$this->receive("SYN 8 27 5 4\r\n");
		$this->receive("GTC A\r\n");
		$this->receive("BLP AL\r\n");
		$this->receive("PRP PHH O1%20234\r\n");
		$this->receive("PRP PHM 56%20789\r\n");
		$this->receive("LSG 0 Sifth\r\n");
		$this->receive("LSG 1 Jedis\r\n");
		$this->receive("LST emperor@empire.com Emperor 13 0\r\n");
		$this->receive("BPR MOB Y\r\n");

		$this->receive("LST luke@rebels.org Luke 3 0\r\n");

		$this->send("CHG 9 NLN 0\r\n");
		$this->receive("CHG 9 NLN 0\r\n");

		$this->receive("CHL 0 \r\n");

	}
}

