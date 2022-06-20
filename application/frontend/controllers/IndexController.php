<?php
class IndexController extends Controller{
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('frontend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function registerAction(){
		$this->_view->_title = "<title>Register</title>";
		$this->_view->render($this->_arrParam['controller'] . '/register');
	}
	
	public function addAction(){
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}
}