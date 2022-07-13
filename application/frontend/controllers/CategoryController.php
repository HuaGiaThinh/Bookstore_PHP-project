<?php
class CategoryController extends Controller
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
        $this->_view->_title = '<title>Danh mục sách</title>';

        // pagination
        $totalItem = $this->_model->countItem($this->_arrParam);
        $configPagination = ['totalItemsPerPage'    => 5, 'pageRange' => 3];
        $this->setPagination($configPagination);
        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);

        $this->_view->items = $this->_model->listItems($this->_arrParam);
        $this->_view->render($this->_arrParam['controller'] . '/index');
    }
}
