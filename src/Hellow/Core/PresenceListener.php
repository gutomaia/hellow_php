<?php
interface Core_PresenceListener {
	function onContactAvaiable($contact);
	function onContactBusy($contact);
	function onContactIdle($contact);
	function onContactBeRightBack($contact);
	function onContactAway($contact);
	function onContactOnPhone($contact);
	function onContactOutLunch($contact);	
}
