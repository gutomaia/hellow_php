<?php
interface Core_ConnectionListener {
	function onLogged($connection);
	function onConnected($connection);
}
