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

		$configPagination = array('totalItemsPerPage'	=> 3, 'pageRange' => 3);
		$this->setPagination($configPagination);

		$this->_view->pagination = new Pagination($totalItem, $this->_pagination);
		$this->_view->items = $this->_model->listItems($this->_arrParam);
		$this->_view->groupSelect = $this->_model->getGroup(true);

		$this->_view->render($this->_arrParam['controller'] . '/index');
	}

	public function formAction()
	{
		$this->_view->_title = "ADD USER";

		$flagId = false;
		if (isset($this->_arrParam['id'])) {
			$this->_view->_title = "EDIT USER";
			$id = $this->_arrParam['id'];
			$flagId = true;
			$this->_view->data = $this->_model->singleItem($this->_arrParam);
		}

		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];

			$queryUserName	= "SELECT `id` FROM `" . TBL_USER . "` WHERE `username` = '" . $this->_arrParam['form']['username'] . "'";
			$queryEmail		= "SELECT `id` FROM `" . TBL_USER . "` WHERE `email` = '" . $this->_arrParam['form']['email'] . "'";

			if (isset($this->_arrParam['id'])) {
				$queryUserName 	.= " AND `id` <> '" . $this->_arrParam['id'] . "'";
				$queryEmail 	.= " AND `id` <> '" . $this->_arrParam['id'] . "'";
			}

			$validate = new Validate($data);
			$validate->addRule('username', 'string-notExistRecord', ['database' => $this->_model, 'query' => $queryUserName, 'min' => 5, 'max' => 100])
				->addRule('email', 'email-notExistRecord', ['database' => $this->_model, 'query' => $queryEmail])
				->addRule('status', 'select')
				->addRule('group_id', 'select');

			isset($this->_arrParam['id']) ? '' : $validate->addRule('password', 'password', ['action' => 'add']);
			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				if ($flagId) {
					$this->_model->updateItem($data, $id);
				} else {
					$this->_model->addItem($data);
				}
				URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->data = $data;
				$this->_view->errors = $validate->showErrors();
			}
		}

		$this->_view->render($this->_arrParam['controller'] . '/form');
	}

	public function profileAction()
	{
		$this->_view->_title = "User Profile";

		$userInfo = Session::get('user');
        $this->_view->data       = $this->_model->infoItem($userInfo);

        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $this->_model->updateProfile($data, $userInfo);
            URL::redirect('frontend', 'index', 'notice', ['type' => 'updateProfile-success']);
        }
        $this->_view->render('user' . '/profile');
	}

	public function changePasswordAction()
	{
		$this->_view->_title = "Change Password";

		$this->_view->data = $this->_model->singleItem($this->_arrParam);

		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];

			$validate = new Validate($data);
			$validate->addRule('password', 'password', ['action' => 'edit']);

			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				$this->_model->updateItem($data, $data['id']);
				URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->data = $data;
				$this->_view->errors = $validate->showErrors();
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/changePassword');
	}

	public function changeStatusAction()
	{
		$result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-status']);
		echo $result;
	}

	public function changeGroupAction()
	{
		$this->_model->handleStatus($this->_arrParam, ['task' => 'change-group']);
	}

	public function changeGroupAcpAction()
	{
		$this->_model->handleStatus($this->_arrParam, ['task' => 'change-groupACP']);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}

	public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}
}
