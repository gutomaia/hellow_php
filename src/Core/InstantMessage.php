<?php
interface Core_InstantMessage {
	function initialPresence(); //
	function login($username, $password);
	function connect();
	function disconnect();
}

