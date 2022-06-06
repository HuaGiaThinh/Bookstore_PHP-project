<?php
class GroupController extends Controller
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
		$this->_view->_title = "Group List";
		$this->_view->countItemFilter = $this->_model->countItemByStatus($this->_arrParam);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
	
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function formAction()
	{
		$this->_view->_title = "Group Form";
		$this->_view->render($this->_arrParam['controller'] . '/form');
	}

	public function ajaxStatusAction()
	{
		$result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-ajax-status']);

		echo json_encode($result);
	}

	public function ajaxACPAction()
	{
		$result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-ajax-ACP']);

		echo json_encode($result);
	}


	public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}
}