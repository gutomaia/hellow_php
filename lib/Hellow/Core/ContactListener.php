<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Core;

interface ContactListener {
	function onAddContact($contact);
	function onRemoveContact($contact);
	function onAddGroup($group);
	function onRemoveGroup($group);
}

