<?php

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
