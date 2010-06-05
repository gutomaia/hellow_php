<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

interface Hellow_Core_ConnectionHandle {
	function connect($host, $port);
	function disconnect();
	function nextCommand();
	function hasMoreCommands();
	function send($cmd);
}