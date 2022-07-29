<?php
class BookController extends Controller
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
        $this->_view->_title = "Book List";
        $this->_view->countItemFilter = $this->_model->countItemByStatus($this->_arrParam);
        $totalItem = $this->_model->countItem($this->_arrParam);

        $configPagination = array('totalItemsPerPage'    => 5, 'pageRange' => 3);
        $this->setPagination($configPagination);
        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);

        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->categorySelect = $this->_model->getCategory(true);

        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function formAction()
    {
        $this->_view->_title = "ADD BOOK";
        $this->_view->categorySelect = $this->_model->getCategory(true);
        
        if (isset($_FILES['picture'])) $this->_arrParam['form']['picture'] = $_FILES['picture'];

        
        $flagId = false;
        if (isset($this->_arrParam['id'])) {
            $this->_view->_title = "EDIT BOOK";
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
            $validate->addRule('name', 'string', ['min' => 3, 'max' => 255])
                ->addRule('price', 'int', ['min' => 1000, 'max' => 1000000])
                ->addRule('special', 'select')
                ->addRule('status', 'select')
                ->addRule('category_id', 'select');

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

    public function profileAction()
    {
        $this->_view->_title = "Book Profile";

        $userInfo = Session::get('user');
        $this->_view->data       = $this->_model->infoItem($userInfo);

        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $this->_model->updateProfile($data, $userInfo);
            URL::redirect('frontend', 'index', 'notice', ['type' => 'updateProfile-success']);
        }
        $this->_view->render('user' . '/profile');
    }

    public function resetPasswordAction()
    {
        $this->_view->_title = "Reset Password";

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
        $this->_view->render($this->_arrParam['controller'] . '/resetPassword');
    }

    public function changePasswordAction()
    {
        $this->_view->_title = "Change Password";
        $user = Session::get('user');
        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];

            $password         = md5($data['old_password']);
            $newPassword     = $data['password'];
            $validate         = new Validate($data);

            $query        = "SELECT `id` FROM `user` WHERE `password` = '$password'";
            $validate->addRule('old_password', 'existRecord', array('database' => $this->_model, 'query' => $query))
                ->addRule('password', 'password', ['action' => 'add'])
                ->addRule('confirm_password', 'confirm', ['confirm-element' => $newPassword]);

            $validate->run();
            $error      = $validate->getError();

            if (empty($error)) {
                $this->_model->changePassword($data, $user);
                URL::redirect('frontend', 'index', 'notice', ['type' => 'updateProfile-success']);
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

    public function changeBookSpecialAction()
    {
        $result = $this->_model->handleStatus($this->_arrParam, ['task' => 'change-bookSpecial']);
        echo $result;
    }

    public function changeCategoryAction()
    {
        $this->_model->handleStatus($this->_arrParam, ['task' => 'change-category']);
    }

    public function deleteAction()
    {
        $this->_model->deleteItems($this->_arrParam);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
    }

    public function multy_activeAction()
    {
        if (isset($this->_arrParam['cid'])) {
            $this->_model->multyActive($this->_arrParam);
            URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
        }
    }

    public function multy_inactiveAction()
    {
        if (isset($this->_arrParam['cid'])) {
            $this->_model->multyInactive($this->_arrParam);
            URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
        }
    }

    public function multy_deleteAction()
    {
        if (isset($this->_arrParam['cid'])) {
            $this->_model->multyDelete($this->_arrParam);
            URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
        }
    }
}
