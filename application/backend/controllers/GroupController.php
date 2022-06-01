<?php
class GroupController extends Controller{
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('backend/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	public function indexAction(){
		$this->_view->_title = "Group";
        $this->_view->items = $this->_model->listItems();
		$this->_view->render('group/index');
	}
	
	public function addAction(){
		$this->_view->render('index/index');
	}
}