<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

interface Hellow_Core_PresenceListener {
	function onContactAvaiable($contact);
	function onContactBusy($contact);
	function onContactIdle($contact);
	function onContactBeRightBack($contact);
	function onContactAway($contact);
	function onContactOnPhone($contact);
	function onContactOutLunch($contact);	
}
