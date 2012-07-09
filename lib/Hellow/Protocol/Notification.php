<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Protocol;

use Hellow\Auth\Tweener;

abstract class Notification extends Msnp
{
    abstract public function getProtocolVersion();
    abstract public function getLocale();

    abstract public function getOSType();
    abstract public function getOSVersion();
    abstract public function getArch();

    abstract public function getClientName();
    abstract public function getClientVersion();
    abstract public function getClientId();

    abstract public function getIdCode();
    abstract public function getCode();

    private $_authenticationHandle = null;

    public function __construct()
    {
        parent::__construct();
        $this->_authenticationHandle = new Tweener;
    }

    public function setAuthenticationHandle($authenticationHandle)
    {
        $this->_authenticationHandle = $authenticationHandle;
    }

    protected function authenticate($lc)
    {
        $this->_passport = $this->_authenticationHandle->authenticate($this->_username, $this->_password, $lc);
    }

    private $_username = null;
    private $_password = null;
    private $_passport = null;

    final protected function getUsername()
    {
        return $this->_username;
    }

    final protected function getPassword()
    {
        return $this->_password;
    }

    protected function connect($host, $port)
    {
        if ($this->_username == null || $this->_password == null) {
            //die('User or password null'); //TODO: see why
        }
        parent::connect($host, $port);
        $this->send($this->ver());
        $this->listen();
    }

    public function login($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
        $this->connect($this->getHost(), $this->getPort());
    }

    public function logout()
    {
        $this->send($this->out());
        $this->disconnect();
    }

    private $_connectionListener = null;
    private $_contactListener = null;
    private $_presenceListener = null;
    private $_callListener = null;

    final public function addConnectionListener($connectionListener)
    {
        $this->_connectionListener = $connectionListener;
    }

    final public function addContactListener($contactListener)
    {
        $this->_contactListener = $contactListener;
    }

    final public function addPresenceListener($presenceListener)
    {
        $this->_presenceListener = $presenceListener;
    }

    final public function addCallListener($callListener)
    {
        $this->_callListener = $callListener;
    }

    //Connection
    final protected function onLogged(){if(!empty($this->_connectionListener)) $this->_connectionListener->onLogged();}
    final protected function onConnected(){if(!empty($this->_connectionListener)) $this->_connectionListener->onConnected();}

    //Contact
    final protected function onAddContact($user, $nick, $lists, $groups=null){if (!empty($this->_contactListener)) {$this->_contactListener->onAddContact(array('user'=>$user, 'nick'=>$nick, 'lists'=>$lists, 'groups'=>$groups));}}
    final protected function onRemoveContact($user){if(!empty($this->_contactListener)) $this->_contactListener->onRemoveContact($user);}
    final protected function onAddGroup($id, $name, $unk=null){if (!empty($this->_contactListener)) {$this->_contactListener->onAddGroup(array('group_id'=>$id, 'name'=>$name));}}
    final protected function onRemoveGroup($group){}

    // Presence
    final protected function onContactOnline($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOnline($contact);}
    final protected function onContactOffline($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOffline($contact);}
    protected final	function onContactAvaiable($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactAvaiable($contact);}
    final protected function onContactBusy($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactBusy($contact);}
    final protected function onContactIdle($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactIdle($contact);}
    final protected function onContactBeRightBack($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactBeRightBack($contact);}
    final protected function onContactAway($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactAway($contact);}
    final protected function onContactOnPhone($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOnPhone($contact);}
    final protected function onContactOutLunch($contact){if(!empty($this->_presenceListener)) $this->_presenceListener->onContactOutLunch($contact);}

    //Call
    final protected function onRing($call, $server, $port, $cki, $username, $nick)
    {
        if(!empty($this->_callListener)) $this->_callListener->onRing($call, $server, $port, $cki, $username, $nick);
    }

    public function ver()
    {
        return "VER ". $this->_trid ." ".$this->getProtocolVersion()." CVR0". $this->EL;
    }

    public function cvr()
    {
        return "CVR " . $this->_trid . " " . $this->getLocale() . " " .	$this->getOSType() . " " . $this->getOSVersion() . " " .
        $this->getArch() . " " . $this->getClientName() . " " .	$this->getClientVersion() . " " . $this->getClientId() . " " .
        $this->getUsername() . $this->EL;
    }

    public function usr()
    {
        if ($this->_passport == null) {
            return "USR " . $this->_trid . " TWN I " . $this->_username . $this->EL;
        } else {
            return "USR " . $this->_trid . " TWN S " . $this->_passport . $this->EL;
        }
    }

    public function syn()
    {
        return "SYN 1 0" . $this->EL;
    }

    public function chg()
    {
        return "CHG " . $this->_trid . " NLN 0" . $this->EL;
    }

    public function qry($chl = null)
    {
        return "QRY ".$this->_trid . " ". $this->getIdCode(). " 32".$this->EL.$this->challenger($chl);
    }

    public function challenger($chl)
    {
        return md5($chl.$this->getCode());
    }

    public function out()
    {
        return "OUT" . $this->EL;
    }
}
