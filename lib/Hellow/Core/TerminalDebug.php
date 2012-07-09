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

class TerminalDebug implements CommandListener {

	function onCommandReceived($command){
		echo "\033[31m".$command;
		//echo "<p style=\"color:#99cc00;\" >" . $cmd . "</p>";		
		//echo $command;
	}

	function onCommandSended($command){
		echo "\033[32m".$command;
		//echo "<p style=\"color:#ff0000;\" >" . $command . "</p>";
		//echo $command;
	}
}
