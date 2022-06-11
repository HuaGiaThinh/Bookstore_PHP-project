<?php
class UserController extends Controller
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
		$this->_view->_title = "User List";
		$this->_view->countItemFilter = $this->_model->countItemByStatus($this->_arrParam);
		$totalItem = $this->_model->countItem($this->_arrParam);

		$configPagination = array('totalItemsPerPage'	=> 4, 'pageRange' => 3);
		$this->setPagination($configPagination);

		$this->_view->pagination = new Pagination($totalItem, $this->_pagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
	
		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function formAction()
	{
		$this->_view->_title = "ADD USER";

		$requirePassword = true;
		$flagId = false;
		if (isset($this->_arrParam['id'])) {
			$this->_view->_title = "EDIT USER";
			$requirePassword = false;
			$id = $this->_arrParam['id'];
			$flagId = true;
			$this->_view->data = $this->_model->singleItem($this->_arrParam);
		}

		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];

			$validate = new Validate($data);
			$validate->addRule('username', 'string', ['min' => 5, 'max' => 50])
				->addRule('password', 'password', ['action' => 'edit'], $requirePassword)
				->addRule('email', 'email')
				->addRule('fullname', 'string', ['min' => 10, 'max' => 100])
				->addRule('status', 'select')
				->addRule('group_id', 'select');

			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				if ($flagId) {
					$this->_model->updateItem($data, $id);
				} else {
					$this->_model->addItem($data);
				}
				URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
				$this->_view->flagSuccess = true;
			} else {
				$this->_view->data = $data;
				$this->_view->errors = $validate->showErrors();
			}
		}

		$this->_view->render($this->_arrParam['controller'] . '/form');
	}

	public function changeStatusAction() {
		$this->_model->handleStatus($this->_arrParam, ['task' => 'change-status']);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');

	}

	public function changeGroupAcpAction() {
		$this->_model->handleStatus($this->_arrParam, ['task' => 'change-groupACP']);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}
}
