<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/
 
class Hellow_Auth_Tweener implements Hellow_Core_Authentication{
	var $EL = "\r\n";
	private $passportProps = null;
	
	function extractHttpResponseHeader($httpResponse){
		$props = array();
		$cutter = strpos($httpResponse, $this->EL.$this->EL);
		$header = substr($httpResponse, 0, $cutter);
		$parameters_values = explode($this->EL, $header);
		foreach($parameters_values as $parameter){
			$cutter = strpos($parameter, ":");
			$key = substr($parameter,0, $cutter);
			$value = substr($parameter, $cutter+2, strlen($parameter) );			
			$props[$key] = $value;
		}
		return $props;
	}

	function extractVarParams($params) {
		$props = array();
		$parameters_values = explode(',',$params);
		foreach($parameters_values as $parameter){
			$cutter = strpos($parameter, "=");
			$key = substr($parameter,0, $cutter);
			$value = substr($parameter, $cutter+1,strlen($parameter) );
			$props[$key] = $value;			
		}
		return $props;
	}

	function connectToTheNexus() {
		$requestUrl = 'nexus.passport.com/rdr/pprdr.asp';
		$httpRequest = $this->buildHttpRequestHeader($requestUrl);
		$httpResponse = $this->request($requestUrl, 443, $httpRequest);
		$responseHeader = $this->extractHttpResponseHeader($httpResponse);
		$passportURLS = $responseHeader['PassportURLs'];
		$this->passportProps = $this->extractVarParams($passportURLS);
	}

	function buildHttpRequestHeader($url,$params = array()) {
		$requestHeader = '';
		$host = substr($url, 0,strpos($url,'/'));
		$getRequest = substr($url, strpos($url,'/'));
		$params['Host'] = $host;
		$requestHeader .= 'GET '.$getRequest. ' HTTP/1.1'.$this->EL;
		foreach ($params as $paramKey=>$paramValue)
				$requestHeader .= $paramKey.': '.$paramValue.$this->EL;
		$requestHeader .= $this->EL;
		return $requestHeader;
	}

	function buildParamVars($params){
		$paramVars = '';
		foreach($params as $paramKey=>$paramValue){
			if ($paramKey=='lc'){
				$paramVars.=$paramValue;
			}else{
				$paramVars.=$paramKey.'='.$paramValue;
				$paramVars.=',';
			}
		}
		return $paramVars;
	}

	function encode($var){
		return str_replace("@", "%40", $var);
	}

	function request($url, $port, $httpRequest){
		$host = substr($url, 0,strpos($url,'/'));
		if ($port == 443){
			$host = 'ssl://'.$host;
		}
		$fp = fsockopen($host, $port, $errno, $errstr);
		if (!$fp){
			echo '>>>>ERRO'. $errno. ' '. $errstr.' '.$host;
			exit();
			//TODO: throw Exception;
		}
		$httpResponse = '';
		fwrite($fp, $httpRequest);
		while (!feof($fp)) {
			$httpResponse .= fgets($fp, 128);
		}
		fclose($fp);
		return $httpResponse;		
	}

	function performTheLogin($username, $password, $lc){
		$DALogin = $this->passportProps['DALogin'];
		$authParams = array();
		$authParams['Passport1.4 OrgVerb']= 'GET';
		$authParams['OrgURL'] = 'http%3A%2F%2Fmessenger%2Emsn%2Ecom';
		$authParams['sign-in'] = $this->encode($username);
		$authParams['pwd'] = $this->encode($password);
		$authParams['lc'] = $lc;
		$authorization = $this->buildParamVars($authParams);
		$requestParams = array();
		$requestParams['Authorization'] = $authorization;
		$httpRequest = $this->buildHttpRequestHeader($DALogin, $requestParams);
		$httpResponse = $this->request($DALogin, 443, $httpRequest);
		$httpHeader = $this->extractHttpResponseHeader($httpResponse);
		$authenticationInfo = $httpHeader['Authentication-Info'];
		$authResponse = $this->extractVarParams($authenticationInfo);
		$fromPP = $authResponse['from-PP'];
		return $fromPP;
	}
	
	function authenticate($username, $password, $lc){
			$this->connectToTheNexus();
			$token = $this->performTheLogin($username, $password, $lc);
			$token = substr($token, 1, (strlen($token) - 2) );
			return $token;
	}
}