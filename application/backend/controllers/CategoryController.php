<?php
class CategoryController extends Controller
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
		$this->_view->_title = "Category List";
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
		$this->_view->_title = "ADD CATEGORY";

        $user = Session::get('user');
		$flagId = false;
		if (isset($this->_arrParam['id'])) {
			$this->_view->_title = "EDIT CATEGORY";
			$id = $this->_arrParam['id'];
			$flagId = true;
			$this->_view->data = $this->_model->singleItem($this->_arrParam);
		}

		if (isset($this->_arrParam['form'])) {
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('name', 'string', ['min' => 5, 'max' => 255])
				->addRule('status', 'select');

			$validate->run();
			$error      = $validate->getError();

			if (empty($error)) {
				if ($flagId) {
					$this->_model->updateItem($this->_arrParam, $user['info']);
				} else {
					$this->_model->addItem($this->_arrParam, $user['info']);
				}
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
			} else {
				$this->_view->data = $this->_arrParam['form'];
				$this->_view->errors = $validate->showErrors();
			}
		}

		$this->_view->render($this->_arrParam['controller'] . '/form');
	}

	public function changeStatusAction() {
		$result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-status']);
		echo $result;
	}

	public function deleteAction()
	{
		$this->_model->deleteItems($this->_arrParam);
		URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
	}
}