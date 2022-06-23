<?php
class DashboardController extends Controller
{
	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->_title = "Dashboard";
		$this->_view->render('dashboard/index');
	}

	public function loginAction()
	{
		$userInfo	= Session::get('user');
		if (@$userInfo['login'] == 1 && (@$userInfo['time'] + TIME_LOGIN >= time())) {
			URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
		}

		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('login.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();

		$this->_view->_title = "Admin Login";
		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];
			$validate	= new Validate($data);

			$email	= $data['email'];
			$password	= md5($data['password']);

			$query		= "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'active'";
			$validate->addRule('email', 'existRecord', array('database' => $this->_model, 'query' => $query));
			$validate->run();

			if ($validate->isValid() == true) {
				$infoUser		= $this->_model->infoItem($this->_arrParam);
				$arraySession	= [
					'login'		=> true,
					'info'		=> $infoUser,
					'time'		=> time(),
					'group_acp'	=> $infoUser['group_acp']
				];
				Session::set('user', $arraySession);
				URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->errors	= $validate->showErrorLogin();
			}
		}

		// $this->_view->render('dashboard' . '/login');
		$this->_view->render($this->_arrParam['controller'] . '/login');
	}

	public function logoutAction(){
		Session::delete('user');
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'login');
	}
}
