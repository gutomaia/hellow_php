<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Test;

use Hellow\Core\ConnectionHandle;

class MockConnection implements ConnectionHandle
{
    public $sended = null;
    public $received = null;
    public $host;
    public $port;

    public function connect($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function disconnect()
    {
    }

    public function send($cmd)
    {
        $this->sended = $cmd;
    }

    public function receive($cmd)
    {
        $this->received = $cmd;
    }

    public function nextCommand()
    {
        return null;
    }

    public function hasMoreCommands()
    {
        return false;
    }

}
