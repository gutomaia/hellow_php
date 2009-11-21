<?php
interface Core_ContactListener {
	function onAddContact($contact);
	function onRemoveContact($contact);
	function onAddGroup($group);
	function onRemoveGroup($group);
}
