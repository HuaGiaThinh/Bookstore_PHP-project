<?php
class DashboardController extends Controller{
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		$this->_view->_title = "Dashboard";
		$this->_view->render('dashboard/index');
	}
	
	public function addAction(){
		$this->_view->render('index/index');
	}
}