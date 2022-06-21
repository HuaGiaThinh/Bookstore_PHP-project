<?php
class URL
{
	public static function redirect($module = 'default', $controller = 'index', $action = 'index', $options = null){
		$link	= self::createLink($module, $controller, $action, $options);
		header('location: ' . $link);
		exit();
	}

    public static function createLink($module, $controller, $action = 'index', $params = null){

		$queryParams = '';
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$queryParams .= "&$key=$value";
			}
		}

		return sprintf("index.php?module=%s&controller=%s&action=%s%s", $module, $controller, $action, $queryParams);
	}
}
