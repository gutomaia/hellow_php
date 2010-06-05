<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

interface Hellow_Core_ContactListener {
	function onAddContact($contact);
	function onRemoveContact($contact);
	function onAddGroup($group);
	function onRemoveGroup($group);
}
