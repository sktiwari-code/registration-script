<?php
spl_autoload_register('myAutoloader');

function myAutoloader($className)
{
   include 'components/'.$className.'.php';
}
?>