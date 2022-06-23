<?php
class Bootstrap
{

	private $_params;
	private $_controllerObject;

	public function init()
	{
		$this->setParam();

		$controllerName	= ucfirst($this->_params['controller']) . 'Controller';
		$filePath	= APPLICATION_PATH . $this->_params['module'] . DS . 'controllers' . DS . $controllerName . '.php';

		if (file_exists($filePath)) {
			$this->loadExistingController($filePath, $controllerName);
			$this->callMethod();
		} else {
			URL::redirect('frontend', 'index', 'notice', ['type' => 'not-url']);
		}
	}

	// CALL METHODE
	private function callMethod_bug()
	{
		$actionName = $this->_params['action'] . 'Action';
		if (method_exists($this->_controllerObject, $actionName) == true) {
			$module		= $this->_params['module'];
			$controller	= $this->_params['controller'];
			$action		= $this->_params['action'];

			$userInfo	= Session::get('user');
			$logged		= (@$userInfo['login'] == true && (@$userInfo['time'] + TIME_LOGIN >= time()));

			// MODULE ADMIN
			if ($module == 'backend') {
				if ($logged) {
					if ($userInfo['group_acp'] == 1) {
						$this->_controllerObject->$actionName();
					} else {
						URL::redirect('frontend', 'index', 'notice', ['type' => 'not-permission']);
					}
				} else {
					Session::delete('user');
					require_once (APPLICATION_PATH . $module . DS . 'controllers' . DS . 'DashboardController.php');
					
					$dashboardController = new DashboardController($this->_params);
					$dashboardController->loginAction();
				}
				// MODULE DEFAULT
			} else if ($module == 'frontend') {
				$this->_controllerObject->$actionName();
			}
		} else {
			URL::redirect('frontend', 'index', 'notice', ['type' => 'not-url']);
		}
	}

	private function callMethod()
	{
		$actionName = $this->_params['action'] . 'Action';
		if (method_exists($this->_controllerObject, $actionName) == true) {
			$module		= $this->_params['module'];
			$controller	= $this->_params['controller'];
			$action		= $this->_params['action'];

			$userInfo	= Session::get('user');
			$logged		= (@$userInfo['login'] == true && (@$userInfo['time'] + TIME_LOGIN >= time()));
			$pageLogin	= ($controller == 'dashboard') && ($action == 'login');


			// MODULE ADMIN
			if ($module == 'backend') {
				if ($logged) {
					if ($userInfo['group_acp'] == 1) {
						if ($pageLogin) URL::redirect('backend', 'dashboard', 'index');
						if (!$pageLogin) $this->_controllerObject->$actionName();
					} else {
						URL::redirect('frontend', 'index', 'notice', ['type' => 'not-permission']);
					}
				} else {
					Session::delete('user');
					if ($pageLogin) $this->_controllerObject->$actionName();;
					if (!$pageLogin) URL::redirect('backend', 'dashboard', 'login');

				}
				
				// MODULE DEFAULT
			} else if ($module == 'frontend') {
				$this->_controllerObject->$actionName();
			}
		} else {
			URL::redirect('frontend', 'index', 'notice', ['type' => 'not-url']);
		}
	}


	// SET PARAMS
	public function setParam()
	{
		$this->_params 	= array_merge($_GET, $_POST);
		$this->_params['module'] 		= isset($this->_params['module']) ? $this->_params['module'] : DEFAULT_MODULE;
		$this->_params['controller'] 	= isset($this->_params['controller']) ? $this->_params['controller'] : DEFAULT_CONTROLLER;
		$this->_params['action'] 		= isset($this->_params['action']) ? $this->_params['action'] : DEFAULT_ACTION;
	}

	// LOAD EXISTING CONTROLLER
	private function loadExistingController($filePath, $controllerName)
	{
		require_once $filePath;
		$this->_controllerObject = new $controllerName($this->_params);
	}

	// ERROR CONTROLLER
	public function _error()
	{
		require_once APPLICATION_PATH . 'default' . DS . 'controllers' . DS . 'ErrorController.php';
		$this->_controllerObject = new ErrorController($this->_params);
		$this->_controllerObject->setView('default');
		$this->_controllerObject->indexAction();
	}
}
