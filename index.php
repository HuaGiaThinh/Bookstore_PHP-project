<?php

require_once 'define.php';

function my_autoload($className)
{
	require_once LIBRARY_PATH . "{$className}.php";
}

spl_autoload_register('my_autoload');
Session::init();
$bootstrap = new Bootstrap();
$bootstrap->init();
