<?php
ob_start();
if(!session_id())
{
	session_start();
}

//session_regenerate_id(true);

define("HOST", "localhost");
define("USER", "root");
define("PASS", "");
define("DB", "justdemo");
define("BASEURL", "http://localhost/practice/demo-registration");

?>