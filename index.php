<?php

//

define('VNUM','0.1');
$time=explode(' ',microtime());$time=$time[1]+$time[0];$begintime=$time;

require_once 'lib/config.inc.php';
require_once 'lib/helpers.inc.php';
require_once 'lib/route.inc.php';

require_once 'templates/'.TEMPLATE.'/'.$document['meta']['template'].'.php';


if(DEBUG){
	require_once 'lib/debug.inc.php';
}