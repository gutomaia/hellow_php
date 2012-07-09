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

use Hellow\Core\ConnectionListener;
use Hellow\Core\ContactListener;

class MockClient implements ConnectionListener, ContactListener
{
    public $logged = false;
    public $connected = false;
    public $group;
    public $contact;

    public function onLogged()
    {
        $this->logged = true;
    }
    public function onConnected()
    {
        $this->connected = true;
    }
    public function onAddContact($contact)
    {
        $this->contact = $contact;
    }
    public function onRemoveContact($contact)
    {
    }
    public function onAddGroup($group)
    {
        $this->group = $group;
    }
    public function onRemoveGroup($group)
    {
    }

}
