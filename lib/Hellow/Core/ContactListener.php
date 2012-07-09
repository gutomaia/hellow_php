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

interface ContactListener
{
    public function onAddContact($contact);
    public function onRemoveContact($contact);
    public function onAddGroup($group);
    public function onRemoveGroup($group);
}
