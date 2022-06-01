<?php

require_once 'define.php';

function my_autoload($className)
{
	require_once LIBRARY_PATH . "{$className}.php";
}

spl_autoload_register('my_autoload');

$bootstrap = new Bootstrap();
$bootstrap->init();
