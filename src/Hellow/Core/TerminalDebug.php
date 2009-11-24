<?php
class Hellow_Core_TerminalDebug implements Hellow_Core_CommandListener {

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
