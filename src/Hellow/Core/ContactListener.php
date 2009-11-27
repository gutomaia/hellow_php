<?php
interface Hellow_Core_ContactListener {
	function onAddContact($contact);
	function onRemoveContact($contact);
	function onAddGroup($group);
	function onRemoveGroup($group);
}
