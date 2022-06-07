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

		$flagId = false;
		if (isset($this->_arrParam['id'])) {
			$id = $this->_arrParam['id'];
			$flagId = true;
			$this->_view->data = $this->_model->singleItem($this->_arrParam);
		}

		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];

			$validate = new Validate($data);
			$validate->addRule('name', 'string', ['min' => 5, 'max' => 100])
				->addRule('group_acp', 'groupACP')
				->addRule('status', 'status');

			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				if ($flagId) {
					$this->_model->updateItem($data, $id);
					URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
				} else {
					$this->_model->addItem($data);
					URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
				}
				$this->_view->flagSuccess = true;
			} else {
				$this->_view->data = $data;
				$this->_view->errors = $error;
			}
		}

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
