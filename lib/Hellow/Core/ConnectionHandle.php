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

interface ConnectionHandle
{
    public function connect($host, $port);
    public function disconnect();
    public function nextCommand();
    public function hasMoreCommands();
    public function send($cmd);
}
