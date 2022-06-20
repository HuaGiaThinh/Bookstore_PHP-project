<?php
class IndexController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('frontend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function registerAction()
	{
		$this->_view->_title = "<title>Register</title>";

		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];

			$queryUserName	= "SELECT `id` FROM `" . TBL_USER . "` WHERE `username` = '" . $this->_arrParam['form']['username'] . "'";
			$queryEmail		= "SELECT `id` FROM `" . TBL_USER . "` WHERE `email` = '" . $this->_arrParam['form']['email'] . "'";

			$validate = new Validate($data);
			$validate->addRule('username', 'string-notExistRecord', ['database' => $this->_model, 'query' => $queryUserName, 'min' => 5, 'max' => 100])
				->addRule('email', 'email-notExistRecord', ['database' => $this->_model, 'query' => $queryEmail])
				->addRule('password', 'password', ['action' => 'add']);

			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				$this->_model->addItem($data);
				URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'notice');
			} else {
				$this->_view->data = $data;
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/register');
	}

	public function addAction()
	{
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}
}
