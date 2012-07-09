<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Auth;

use Hellow\Core\Authentication;

class Tweener implements Authentication
{
    public $EL = "\r\n";
    private $passportProps = null;

    public function extractHttpResponseHeader($httpResponse)
    {
        $props = array();
        $cutter = strpos($httpResponse, $this->EL.$this->EL);
        $header = substr($httpResponse, 0, $cutter);
        $parameters_values = explode($this->EL, $header);
        foreach ($parameters_values as $parameter) {
            $cutter = strpos($parameter, ":");
            $key = substr($parameter,0, $cutter);
            $value = substr($parameter, $cutter+2, strlen($parameter) );
            $props[$key] = $value;
        }

        return $props;
    }

    public function extractVarParams($params)
    {
        $props = array();
        $parameters_values = explode(',',$params);
        foreach ($parameters_values as $parameter) {
            $cutter = strpos($parameter, "=");
            $key = substr($parameter,0, $cutter);
            $value = substr($parameter, $cutter+1,strlen($parameter) );
            $props[$key] = $value;
        }

        return $props;
    }

    public function connectToTheNexus()
    {
        $requestUrl = 'nexus.passport.com/rdr/pprdr.asp';
        $httpRequest = $this->buildHttpRequestHeader($requestUrl);
        $httpResponse = $this->request($requestUrl, 443, $httpRequest);
        $responseHeader = $this->extractHttpResponseHeader($httpResponse);
        $passportURLS = $responseHeader['PassportURLs'];
        $this->passportProps = $this->extractVarParams($passportURLS);
    }

    public function buildHttpRequestHeader($url,$params = array())
    {
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

    public function buildParamVars($params)
    {
        $paramVars = '';
        foreach ($params as $paramKey=>$paramValue) {
            if ($paramKey=='lc') {
                $paramVars.=$paramValue;
            } else {
                $paramVars.=$paramKey.'='.$paramValue;
                $paramVars.=',';
            }
        }

        return $paramVars;
    }

    public function encode($var)
    {
        return str_replace("@", "%40", $var);
    }

    public function request($url, $port, $httpRequest)
    {
        $host = substr($url, 0,strpos($url,'/'));
        $host = ($port == 443)?'ssl://'.$host:$host;
        $fp = fsockopen($host, $port, $errno, $errstr);
        if (!$fp) {
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

    public function performTheLogin($username, $password, $lc)
    {
        $DALogin = $this->passportProps['DALogin'];
        $authParams = array(
            'Passport1.4 OrgVerb'=> 'GET',
            'OrgURL'=> 'http%3A%2F%2Fmessenger%2Emsn%2Ecom',
            'sign-in'=> $this->encode($username),
            'pwd' => $this->encode($password),
            'lc' => $lc
        );
        $authorization = $this->buildParamVars($authParams);
        $requestParams = array(
            'Authorization' => $authorization
        );
        $httpRequest = $this->buildHttpRequestHeader($DALogin, $requestParams);
        $httpResponse = $this->request($DALogin, 443, $httpRequest);
        $httpHeader = $this->extractHttpResponseHeader($httpResponse);
        $authenticationInfo = $httpHeader['Authentication-Info'];
        $authResponse = $this->extractVarParams($authenticationInfo);
        $fromPP = $authResponse['from-PP'];

        return $fromPP;
    }

    public function authenticate($username, $password, $lc)
    {
            $this->connectToTheNexus();
            $token = $this->performTheLogin($username, $password, $lc);
            $token = substr($token, 1, (strlen($token) - 2) );

            return $token;
    }
}
