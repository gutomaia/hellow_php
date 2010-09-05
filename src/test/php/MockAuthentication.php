<?php
/*  HellowPhp, alpha version
 *  (c) 2009 Gustavo Maia Neto (gutomaia)
 *
 *  HellowPhp and all other Hellow flavors will be always
 *  freely distributed under the terms of an GPLv3 license.
 *
 *  Human Knowledge belongs to the World!
 *--------------------------------------------------------------------------*/

class MockAuthentication implements Hellow_Core_Authentication{
	
	function authenticate($username, $password, $lc) {
		return "t=53*1hAu8ADuD3TEwdXoOMi08sD*2!cMrntTwVMTjoB3p6stWTqzbkKZPVQzA5NOt19SLI60PY!b8K4YhC!Ooo5ug$$&p=5eKBBC!yBH6ex5mftp!a9DrSb0B3hU8aqAWpaPn07iCGBw5akemiWSd7t2ot!okPvIR!Wqk!MKvi1IMpxfhkao9wpxlMWYAZ!DqRfACmyQGG112Bp9xrk04!BVBUa9*H9mJLoWw39m63YQRE1yHnYNv08nyz43D3OnMcaCoeSaEHVM7LpR*LWDme29qq2X3j8N";
	}
}
