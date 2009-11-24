<?php
class Client {
	public static function init() {
		require_once ("Hellow/Core/Authentication.php");
		require_once ("Hellow/Core/CommandListener.php");
		require_once ("Hellow/Core/ConnectionListener.php");
		require_once ("Hellow/Core/ContactListener.php");
		require_once ("Hellow/Core/ClientApp.php");
		require_once ("Hellow/Core/ConnectionHandle.php");
		require_once ("Hellow/Core/SocketConnection.php");
		require_once ("Hellow/Core/TerminalDebug.php");
		require_once ("Hellow/Auth/Tweener.php");
		require_once ("Hellow/Protocol/Msnp.php");
		require_once ("Hellow/Protocol/Notification.php");
		require_once ("Hellow/Protocol/Switchboard.php");
		require_once ("Hellow/Protocol/Msnp8.php");
		require_once ("Hellow/Protocol/Msnc1.php");
	}
}

