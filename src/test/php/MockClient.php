<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

class MockClient implements Hellow_Core_ConnectionListener, Hellow_Core_ContactListener {
	var $logged = false;
	var $connected = false;
	var $group;
	var $contact;

	function onLogged(){
		$this->logged = true;
	}
	function onConnected(){
		$this->connected = true;
	}
	function onAddContact($contact){
		$this->contact = $contact;
	}
	function onRemoveContact($contact){
	}
	function onAddGroup($group){
		$this->group = $group;
	}
	function onRemoveGroup($group){
	}

}
