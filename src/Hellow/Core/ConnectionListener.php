<?php
interface Hellow_Core_ConnectionListener {
	function onLogged($connection);
	function onConnected($connection);
}
