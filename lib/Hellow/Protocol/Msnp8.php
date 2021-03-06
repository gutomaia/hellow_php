<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributable under the terms of an GPLv3 licence.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Protocol;

class Msnp8 extends Notification
{
    private $MSN_HOST = 'messenger.hotmail.com';
    private $MSN_PORT = 1863;

    private $PROTOCOL_VERSION = 'MSNP8';
    private $LOCALE_ID = '0x0409';

    private $OS_TYPE = 'win';
    private $OS_VERSION = '4.10'; //windows 98;
    private $CPU_ARCHITECTURE = 'i386';
    private $CLIENT_NAME = 'MSNMSGR';
    private $CLIENT_VERSION = '6.0.0602'; //5.0.0544
    //Chalenger
    private $CLIENT_ID = 'MSMSGS';
    private $CLIENT_IDCODE = 'msmsgs@msnmsgr.com';
    private $CLIENT_CODE = 'Q1P7W2E4J9R8U3S5'; // needed for the chalenger

    public function __construct()
    {
        parent::__construct();
    }

    public function getHost()
    {
        return $this->MSN_HOST;
    }

    public function getPort()
    {
        return $this->MSN_PORT;
    }

    public function getProtocolVersion()
    {
        return $this->PROTOCOL_VERSION;
    }

    public function getLocale()
    {
        return $this->LOCALE_ID;
    }

    public function getOSType()
    {
        return $this->OS_TYPE;
    }

    public function getOSVersion()
    {
        return $this->OS_VERSION;
    }

    public function getArch()
    {
        return $this->CPU_ARCHITECTURE;
    }

    public function getClientName()
    {
        return $this->CLIENT_NAME;
    }

    public function getClientVersion()
    {
        return $this->CLIENT_VERSION;
    }

    public function getClientId()
    {
        return $this->CLIENT_ID;
    }

    public function getIdCode()
    {
        return $this->CLIENT_IDCODE;
    }

    public function getCode()
    {
        return $this->CLIENT_CODE;
    }

    public function execute($command)
    {
        $params = explode(" ", trim($command));
        switch ($params[0]) {
            case "VER" :
                $this->send($this->cvr());
                break;
            case "CVR" :
                $this->send($this->usr());
                break;
            case "XFR" :
                $host_port = explode(":", $params[3]);
                $this->connect($host_port[0], $host_port[1]);
                break;
            case "USR" :
                if ($params[2] == "TWN") {
                    $this->authenticate($params[4]);
                    $this->send($this->usr());
                } elseif ($params[2] == "OK") {
                    $this->onLogged(null);
                    $this->send($this->syn());
                }
                break;
            case "SYN" :
                $this->send($this->chg());
                break;
            case "GTC" :
                break;
            case "BLP" :
                break;
            case "PRP" :
                break;
            case "LSG" :
                if (sizeof($params) == 4) {
                    $this->onAddGroup($params[1], $params[2], $params[3]);
                } elseif (sizeof($params) == 3) {
                    $this->onAddGroup($params[1], $params[2]);
                }
                break;
            case "LST" :
                if (sizeof($params) == 5) {
                    $this->onAddContact($params[1], $params[2], $params[3], $params[4]);
                } elseif (sizeof($params) == 4) {
                    $this->onAddContact($params[1], $params[2], $params[3]);
                }
                break;
            case "PHH":
            case "PHW":
            case "PHM":
            case "MOB":
            case "MBE":
            case "BPR" :
                break;
            case "ILN" :
                break;
            case "FLN" :
                //$this->onContactOffline($contact);
                break;
            case "NLN" :
                break;
            case "MSG" :
                break;
            case "RNG" :
                $this->onRing($params[1], $params[2], $params[3], $params[4], $params[5], $params[6]);
                break;
            case "CHG" :
                $this->onConnected();
                break;
            case "CHL" :
                $this->send($this->qry($params[2]));
                break;
            case "QRY" :
            break;
            case "207" :
                $this->disconnect();
                break;
            default :
                //$cont = false;
                //die();
                //$this->disconnect();
        }
    }
}
