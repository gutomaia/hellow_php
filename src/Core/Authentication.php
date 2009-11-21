<?php
interface Core_Authentication {
	function authenticate($username, $password, $lc);
}
