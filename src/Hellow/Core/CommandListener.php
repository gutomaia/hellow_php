<?php
interface Hellow_Core_CommandListener {
	function onCommandReceived($command);
	function onCommandSended($command);
}
