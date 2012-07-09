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

interface PresenceListener
{
    public function onContactAvaiable($contact);
    public function onContactBusy($contact);
    public function onContactIdle($contact);
    public function onContactBeRightBack($contact);
    public function onContactAway($contact);
    public function onContactOnPhone($contact);
    public function onContactOutLunch($contact);
}
