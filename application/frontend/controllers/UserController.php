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

    public function profileAction()
    {
        $userInfo = Session::get('user');
        $this->_view->data       = $this->_model->infoItem($userInfo);

        if (isset($this->_arrParam['form'])) {
            $data       = $this->_arrParam['form'];
            $this->_model->updateItem($data, $userInfo);
            URL::redirect($this->_arrParam['module'], 'index', 'notice', ['type' => 'updateProfile-success']);
        }
        $this->_view->render($this->_arrParam['controller'] . '/profile');
    }

    public function logoutAction()
    {
        Session::delete('user');
        URL::redirect($this->_arrParam['module'], 'index', 'index');
    }
}
