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

        $configPagination = array('totalItemsPerPage'    => 4, 'pageRange' => 3);
        $this->setPagination($configPagination);

        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);
        $this->_view->items = $this->_model->listItems($this->_arrParam);

        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function formAction()
    {
        $this->_view->_title = "ADD CATEGORY";
        if (isset($_FILES['picture'])) $this->_arrParam['form']['picture'] = $_FILES['picture'];

        $flagId = false;
        if (isset($this->_arrParam['id'])) {
            $this->_view->_title = "EDIT CATEGORY";
            $flagId = true;
            $this->_view->data = $this->_model->singleItem($this->_arrParam);
        }

        if (isset($this->_arrParam['form'])) {
            if ($flagId) {
                if ($this->_arrParam['form']['picture']['name'] == null) {
                    unset($this->_arrParam['form']['picture']);
                }
            }

            $validate = new Validate($this->_arrParam['form']);
            $validate->addRule('name', 'string', ['min' => 5, 'max' => 255])
                ->addRule('status', 'select');
            if (isset($this->_arrParam['form']['picture'])) {
                $validate->addRule('picture', 'file', ['min' => 100, 'max' => 1000000, 'extension' => ['jpg', 'png']], false);
            }
                
            $validate->run();
            $error      = $validate->getError();

            if (empty($error)) {
                if ($flagId) {
                    $this->_model->updateItem($this->_arrParam);
                } else {
                    $this->_model->addItem($this->_arrParam);
                }
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
            } else {
                unset($this->_arrParam['form']['picture']);
                $this->_view->data = $this->_arrParam['form'];
                $this->_view->errors = $validate->showErrors();
            }
        }

        $this->_view->render($this->_arrParam['controller'] . '/form');
    }

    public function changeStatusAction()
    {
        $result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-status']);
        echo $result;
    }

    public function changeShowAtHomeAction()
    {
        $result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-showAtHome']);
        echo $result;
    }

    public function changeOrderingAction()
    {
        $result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-ordering']);
        echo $result;
    }

    public function deleteAction()
    {
        $this->_model->deleteItems($this->_arrParam);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }
}
