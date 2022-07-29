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

    public function orderAction()
    {
        $cart       = Session::get('cart');
        $bookID     = $this->_arrParam['book_id'];
        $price      = $this->_arrParam['price'];

        if (isset($this->_arrParam['quantity_cart'])) {
            $quantity = @$this->_arrParam['quantity_cart'];
        } else {
            $quantity = @$this->_arrParam['quantity'];
        }

        if ($quantity != null) {
            if (isset($this->_arrParam['quantity_cart'])) {
                $cart['quantity'][$bookID]  = $quantity;
            } else {
                @$cart['quantity'][$bookID]  += $quantity;
            }
            $cart['price'][$bookID]     = $price * $cart['quantity'][$bookID];
        } else {
            if (empty($cart)) {
                $cart['quantity'][$bookID]  = 1;
                $cart['price'][$bookID]     = $price;
            } else {
                if (key_exists($bookID, $cart['quantity'])) {
                    $cart['quantity'][$bookID]  += 1;
                    $cart['price'][$bookID]     = $price * $cart['quantity'][$bookID];
                } else {
                    $cart['quantity'][$bookID]  = 1;
                    $cart['price'][$bookID]     = $price;
                }
            }
        }

        Session::set('cart', $cart);
        $quantityCart   = array_sum($cart['quantity']);
        echo $quantityCart;
    }

    public function ajaxQuickViewAction()
    {
        $result = $this->_model->infoItem($this->_arrParam, ['task' => 'quick-view-book']);
        $pictureURL = HelperFrontend::createPictureURL($result['picture'], $this->_arrParam);
        $detailItem = URL::createLinkBookForUser($result, $this->_arrParam);

        $result['pictureURL'] = $pictureURL;
        $result['detailItem'] = $detailItem;
        $result['linkToCart'] = URL::createLink($this->_arrParam['module'], 'index', 'order');

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
            $validate->addRule('username', 'string-notExistRecord', ['database' => $this->_model, 'query' => $queryUserName, 'min' => 5, 'max' => 25])
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
            URL::redirect($this->_arrParam['module'], 'index', 'index', null, 'trang-chu.html');
        }


        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $validate   = new Validate($data);

            $email      = $data['email'];
            $password   = md5($data['password']);

            $query = "SELECT `id` FROM `user` WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'active'";
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
                
                $urlRedirect = ROOT_URL .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], $this->_arrParam['action'], null, $urlRedirect);
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
