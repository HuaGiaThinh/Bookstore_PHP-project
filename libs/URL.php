<?php
class URL
{
    public static function redirect($module = 'default', $controller = 'index', $action = 'index'){
		header("location: index.php?module=$module&controller=$controller&action=$action");
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
