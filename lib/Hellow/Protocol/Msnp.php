<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

namespace Hellow\Protocol;

use Hellow\Core\SocketConnection;

abstract class Msnp
{
    public $EL = "\r\n";

    protected $_trid = 1;

    private $_connection;

    private $_connectionHandle;

    public function __construct ()
    {
        $this->_connectionHandle = new SocketConnection;
    }

    public function setConnectionHandle($connectionHandle)
    {
        $this->_connectionHandle = $connectionHandle;
    }

    private $_commandListener = null;

    final public function addCommandListener($commandListener)
    {
        $this->_commandListener = $commandListener;
    }

    final protected function onCommandReceived($command){if(!empty($this->_commandListener)) $this->_commandListener->onCommandReceived($command);}
    final protected function onCommandSended($command){if(!empty($this->_commandListener)) $this->_commandListener->onCommandSended($command);}

    abstract public function getHost();
    abstract public function getPort();
    abstract public function execute($command);

    final protected function send($cmd)
    {
        $this->_connectionHandle->send($cmd);
        $this->onCommandSended($cmd);
        $this->_trid++;
    }

    protected function connect($host, $port)
    {
        $this->_connectionHandle->connect($host, $port);
    }

    protected function disconnect()
    {
        $this->_connectionHandle->disconnect();
    }

    final protected function listen()
    {
        while ($this->_connectionHandle->hasMoreCommands()) {
            $command = $this->_connectionHandle->nextCommand();
            if (trim($command) != "") {
                $this->execute($command);
                $this->onCommandReceived($command);
            }
        }
    }
}
