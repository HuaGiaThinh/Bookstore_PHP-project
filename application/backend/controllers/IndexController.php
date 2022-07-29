<?php
class IndexController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('backend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function dashboardAction()
    {
        $this->_view->_title = "Dashboard";
        $items = $this->_model->countTableItem();

        $arrItems = [
            'group'     => [
                'icon' => 'ion-ios-people'
            ],
            'user'     => [
                'icon' => 'ion-ios-person'
            ],
            'category'     => [
                'icon' => 'ion-clipboard'
            ],
            'book'     => [
                'icon' => 'ion-ios-book'
            ],
        ];

        foreach ($items as $key => $item) {
            $arrItems[$key]['count'] = $item;
        }

        $this->_view->items = $arrItems;
        $this->_view->render('index/index');
    }

    public function loginAction()
    {
        $userInfo    = Session::get('user');
        if (@$userInfo['login'] == true && $userInfo['time'] + TIME_LOGIN >= time()) {
            URL::redirect('backend', 'index', 'dashboard');
        }

        $this->_templateObj->setFolderTemplate('backend/');
        $this->_templateObj->setFileTemplate('login.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();

        $this->_view->_title = "Admin Login";
        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $validate    = new Validate($data);

            $email      = $data['email'];
            $password   = md5($data['password']);

            $query        = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'active'";
            $validate->addRule('email', 'existRecord', array('database' => $this->_model, 'query' => $query));
            $validate->run();

            if ($validate->isValid() == true) {
                $infoUser        = $this->_model->infoItem($this->_arrParam, ['task' => 'login']);
                $arraySession    = [
                    'login'         => true,
                    'info'          => $infoUser,
                    'time'          => time(),
                    'group_acp'     => $infoUser['group_acp']
                ];
                Session::set('user', $arraySession);
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'index');
            } else {
                $this->_view->errors    = $validate->showErrorLogin();
            }
        }

        $this->_view->render('index' . '/login');
    }

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'login');
    }
}
