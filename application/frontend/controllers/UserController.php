<?php
class UserController extends Controller
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
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }

    public function orderAction()
    {
        $cart       = Session::get('cart');
        $bookID     = $this->_arrParam['book_id'];
        $price      = $this->_arrParam['price'];
        $quantity   = $this->_arrParam['quantity'];

        if ($this->_arrParam['quantity']) {
            $cart['quantity'][$bookID] = $quantity;
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
        URL::redirect($this->_arrParam['module'], 'user', 'cart');
    }

    public function cartAction()
    {
        $this->_view->_title = '<title>Giỏ hàng | BookStore</title>';
        $this->_view->items = $this->_model->listItems($this->_arrParam, ['task' => 'books-in-cart']);
        $this->_view->render($this->_arrParam['controller'] . '/cart');
    }

    public function buyAction()
    {
        $result = $this->_model->saveItems($this->_arrParam, ['task' => 'save-cart']);
        URL::redirect($this->_arrParam['module'], 'index', 'notice', ['type' => 'payment-success', 'id' => $result['id']]);
    }

    public function removeItemFromCartAction()
    {
        $cart       = Session::get('cart');
        $bookID     = $this->_arrParam['book_id'];

        unset($cart['quantity'][$bookID]);
        unset($cart['price'][$bookID]);

        Session::set('cart', $cart);
        URL::redirect($this->_arrParam['module'], $this->_arrParam['controller'], 'cart');
    }

    public function profileAction()
    {
        $this->_view->_title = '<title>Thông tin tài khoản | BookStore</title>';
        $userInfo = Session::get('user');
        $this->_view->data       = $this->_model->infoItem($userInfo);

        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $this->_model->updateItem($data, $userInfo);
            URL::redirect($this->_arrParam['module'], 'index', 'notice', ['type' => 'updateProfile-success']);
        }
        $this->_view->render($this->_arrParam['controller'] . '/profile');
    }

    public function changePasswordAction()
	{
		$this->_view->_title = "<title>Đổi mật khẩu</title>";
		$user = Session::get('user');
		if (isset($this->_arrParam['form'])) {
			$data       = $this->_arrParam['form'];
			
			$password 		= md5($data['old_password']);
			$newPassword 	= $data['password'];
			$validate 		= new Validate($data);

			$query		= "SELECT `id` FROM `user` WHERE `password` = '$password'";
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
				$this->_view->errors = $validate->showErrorsFrontend();
			}
		}
		$this->_view->render($this->_arrParam['controller'] . '/changePassword');
	}

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect($this->_arrParam['module'], 'index', 'index');
    }
}
