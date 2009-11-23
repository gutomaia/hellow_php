<?php
abstract class Hellow_Protocol_Notification extends Hellow_Protocol_Msnp{

	abstract function getProtocolVersion();
	abstract function getLocale();
	
	abstract function getOSType();
	abstract function getOSVersion();	
	abstract function getArch();
	
	abstract function getClientName();	
	abstract function getClientVersion();
	abstract function getClientId();
	
	abstract function getIdCode();
	abstract function getCode();

	private $_authenticationHandle;

	public function __construct() {
		parent::__construct();
		$this->_authenticationHandle = new Hellow_Auth_Tweener;
	}

	public function setAuthenticationHandle($authenticationHandle) {
		$this->_authenticationHandle = $authenticationHandle;
	}


	protected function authenticate($lc){
		return $this->_authenticationHandle->authenticate($this->_username, $this->_password, $lc);		
	}
	
	private $_username = null;
	private $_password = null;

	protected final function getUsername(){
		return $this->_username;
	}
	
	protected final function getPassword(){
		return $this->_password;
	}
	
	protected function connect($host, $port) {		
		if ($this->_username == null || $this->_password == null) {
			//die('User or password null'); //TODO: see why
		}
		parent::connect($host, $port);
		$this->send($this->ver());
		$this->listen();
	}
	

	public function login($username, $password){
		$this->_username = $username;
		$this->_password = $password;
		$this->connect($this->getHost(), $this->getPort());
	}
	
	public function logout() {
		$this->send($this->out());
		$this->disconnect();
	}
	

	private $_connectionListener = null;
	private $_userListener = null;
	private $_groupListener = null;
	
	private $_presenceListener = null;
	
	// DEBUG
	private $_commandListener = null;

	public final function setClientApp($client_app){
		$client_app->setMsn($this);
		//if($client_app instanceOf)
		$this->_connectionListener = & $client_app;
		$this->_userListener = & $client_app;
		$this->_groupListener = & $client_app;
		$this->_presenceListener = & $client_app;
	}
	
	//Connection
	protected final function onLogged($connection){if(!empty($this->_connectionListener)) $this->_connectionListener->onLogged($connection);}
	protected final function onConnected($connection){if(!empty($this->_connectionListener)) $this->_connectionListener->onConnected($connection);}

	//User || Contact
	protected final function onAddUser($user, $nick, $lists, $groups=null){if(!empty($this->_userListener)){$this->_userListener->onAddUser(array('user'=>$user, 'nick'=>$nick, 'lists'=>$lists, 'groups'=>$groups));}}
	protected final function onRemoveUser($user){if(!empty($this->_userListener)) $this->_userListener->onRemoveUser($user);}
	
	//Group	
	protected final function onAddGroup($id, $name, $unk){if(!empty($this->_groupListener)){$this->_groupListener->onAddGroup(array('group_id'=>$id, 'name'=>$name));}}
	protected final function onRemoveGroup($group){}

	// Presence
	protected final function onContactOnline($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOnline($contact);}
	protected final function onContactOffline($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOffline($contact);}
	protected final	function onContactAvaiable($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactAvaiable($contact);}
	protected final function onContactBusy($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactBusy($contact);}
	protected final function onContactIdle($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactIdle($contact);}
	protected final function onContactBeRightBack($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactBeRightBack($contact);}
	protected final function onContactAway($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactAway($contact);}
	protected final function onContactOnPhone($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOnPhone($contact);}
	protected final function onContactOutLunch($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOutLunch($contact);}
	
	
	function ver() {
		return "VER ". $this->_trid ." ".$this->getProtocolVersion()." CVR0". $this->EL;
	}


	function cvr() {
		return "CVR " . $this->_trid . " " . $this->getLocale() . " " .	$this->getOSType() . " " . $this->getOSVersion() . " " .
		$this->getArch() . " " . $this->getClientName() . " " .	$this->getClientVersion() . " " . $this->getClientId() . " " .
		$this->getUsername() . $this->EL;
	}

	function usr() {
		if ($this->_passport == null) {
			return "USR " . $this->_trid . " TWN I " . $this->_username . $this->EL;
		} else {
			return "USR " . $this->_trid . " TWN S " . $this->_passport . $this->EL;
		}
	}

	function syn() {
		return "SYN 1 0" . $this->EL;
	}

	function chg() {
		return "CHG " . $this->_trid . " NLN 0" . $this->EL;
	}

	function qry($chl = null) {
		return "QRY ".$this->_trid . " ". $this->getIdCode(). " 32".$this->EL.$this->challenger($chl);		
	}

	function challenger($chl) {
		return md5($chl.$this->getCode());
	}

	function out() {
		return "OUT" . $this->EL;
	}
}

