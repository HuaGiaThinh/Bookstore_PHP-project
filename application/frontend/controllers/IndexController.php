<?php
class IndexController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('frontend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function indexAction()
    {
        $this->_view->specialBook = $this->_model->listItems($this->_arrParam, ['task' => 'special-books']);
        $this->_view->topCategory = $this->_model->listItems($this->_arrParam, ['task' => 'top-category']);
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function ajaxQuickViewAction()
    {
        $result = $this->_model->infoItem($this->_arrParam, ['task' => 'quick-view-book']);

        $pictureURL = HelperFrontend::createPictureURL($result['picture'], $this->_arrParam);
        $detailItem = URL::createLink($this->_arrParam['module'], 'book', 'detail', ['book_id' => $result['id']]);

        $result['pictureURL'] = $pictureURL;
        $result['detailItem'] = $detailItem;
        $result['linkToCart'] = URL::createLink($this->_arrParam['module'], 'user', 'order');
        echo json_encode($result);
    }

    public function registerAction()
    {
        $userInfo    = Session::get('user');
        if (@$userInfo['login'] == true && (@$userInfo['time'] + TIME_LOGIN >= time())) {
            URL::redirect($this->_arrParam['module'], 'index', 'index');
        }
        $this->_view->_title = "<title>Register</title>";

        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];

            $queryUserName    = "SELECT `id` FROM `" . TBL_USER . "` WHERE `username` = '" . $this->_arrParam['form']['username'] . "'";
            $queryEmail        = "SELECT `id` FROM `" . TBL_USER . "` WHERE `email` = '" . $this->_arrParam['form']['email'] . "'";

            $validate = new Validate($data);
            $validate->addRule('username', 'string-notExistRecord', ['database' => $this->_model, 'query' => $queryUserName, 'min' => 5, 'max' => 100])
                ->addRule('email', 'email-notExistRecord', ['database' => $this->_model, 'query' => $queryEmail])
                ->addRule('password', 'password', ['action' => 'add']);

            $validate->run();
            $error      = $validate->getError();

            if (empty($error)) {
                $this->_model->addItem($data);
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'notice', ['type' => 'register-success']);
            } else {
                $this->_view->data = $data;
                $this->_view->errors = $validate->showErrorsFrontend();
            }
        }
        $this->_view->render($this->_arrParam['controller'] . '/register');
    }

    public function loginAction()
    {
        $this->_view->_title = "<title>Login</title>";
        $userInfo    = Session::get('user');
        if (@$userInfo['login'] == true && (@$userInfo['time'] + TIME_LOGIN >= time())) {
            URL::redirect($this->_arrParam['module'], 'index', 'index');
        }


        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $validate    = new Validate($data);

            $email    = $data['email'];
            $password    = md5($data['password']);

            $query        = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'active'";
            $validate->addRule('email', 'existRecord', array('database' => $this->_model, 'query' => $query));
            $validate->run();

            if ($validate->isValid() == true) {
                $infoUser        = $this->_model->infoItem($this->_arrParam, ['task' => 'login']);
                $arraySession    = [
                    'login'        => true,
                    'info'        => $infoUser,
                    'time'        => time(),
                    'group_acp'    => $infoUser['group_acp']
                ];
                Session::set('user', $arraySession);
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], $this->_arrParam['action']);
            } else {
                $this->_view->errors    = $validate->showErrorLogin();
            }
        }

        $this->_view->render('index/login');
    }

    public function noticeAction()
    {
        $this->_view->_title = "<title>Notice</title>";
        $this->_view->render('index/notice');
    }
}
