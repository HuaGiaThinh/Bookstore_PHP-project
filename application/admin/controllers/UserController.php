<?php
class UserController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function loginAction(){
		echo '<h3>' . __METHOD__ . '</h3>';
		$this->_view->setTitle('Login');
		$this->_view->appendCSS(array('user/css/abc.css'));
		$this->_view->appendJS(array('user/js/test.js'));
		$this->_view->render('user/login', true);
	}
	
	public function logoutAction(){
		echo '<h3>' . __METHOD__ . '</h3>';
		$this->_view->setTitle('Logout');
		$this->_view->appendJS(array('user/js/test.js'));
		$this->_view->render('user/logout', true);
	}
}