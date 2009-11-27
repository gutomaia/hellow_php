<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowAs and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

/**
 * Concrete TweenerAuthentication
 * 
 * Used to authenticate on the msn, much refactoring is still needed to make it
 * more preatty
 *
 * @author Gustavo Maia Neto (gutomaia)
 */

class Hellow_Auth_Tweener implements Hellow_Core_Authentication{
	var $EL = "\r\n";
	
	function authenticate($username, $password, $lc) {
		$errno = null;
		$errstr = null;
		$in = '';
		$out = '';
		$fp = fsockopen("ssl://nexus.passport.com", 443, $errno, $errstr);
		if (!$fp) {
			echo "$errstr ($errno)<br/>\n";
			echo $fp;
		} else {
			$out = "GET /rdr/pprdr.asp".$this->EL.$this->EL;
			fwrite($fp, $out);
			while (!feof($fp)) {
				$in .= fgets($fp, 128);
			}
			//echo $in;
			//echo str_replace("\r\n", '<br />', $in);
			fclose($fp);
			$header = explode($this->EL, $in);			
			$header = explode(',', $header[5]);
			$header = explode('=', $header[1]);
			$header = explode('/', $header[1]);
			// dominio do DALogin = login.live.com
		}
		$errno = null;
		$errstr = null;
		$in = '';
		$out = '';
		$fp = fsockopen('ssl://' . $header[0], 443, $errno, $errstr);
		if (!$fp) {
			//echo "$errstr ($errno)<br/>\n";
		} else {
			$out = 'GET /' . $header[1] . " HTTP/1.1".$this->EL.
			'Authorization: Passport1.4 OrgVerb=GET,OrgURL=http%3A%2F%2Fmessenger%2Emsn%2Ecom,' .
			'sign-in=' . str_replace("@", "%40", $username) . ',pwd=' . urlencode($password) . ',' . $lc . $this->EL .
			'Host: ' . $header[0].$this->EL.$this->EL;
			fwrite($fp, $out);
			//echo str_replace("\r\n", '<br />', $out);
			while (!feof($fp)) {
				$in .= fgets($fp, 128);
			}
			//echo str_replace("\r\n", '<br />', $in);
			fclose($fp);
			$header = explode($this->EL, $in);
			$header = explode(',', $header[22]);
			$header = explode('=', $header[1]);
			$header = "t=" . $header[2] . "=" . substr($header[3], 0, (strlen($header[3]) - 1));
			//$header = substr($header[1], 9, (strlen($header[1]) - 10));
			$out = '';
			/*for ($i = 1; $i  <= sizeof($header); $i++) {
				$out .= $header[$i];
			}*/
			//echo ('<br><br>' . $header);
			//$this->_passport = $header;
			return $header;
			//$header = explode($this->EL, $in);
			//echo ($out);
		}
	}

}

?>
