<?php
class BookController extends Controller
{
    public function __construct($arrParams)
    {
        parent::__construct($arrParams);
        $this->_templateObj->setFolderTemplate('frontend/');
        $this->_templateObj->setFileTemplate('index.php');
        $this->_templateObj->setFileConfig('template.ini');
        $this->_templateObj->load();
    }

    public function listAction()
    {
        $this->_view->_title = '<title>Danh mục sách</title>';

        $listCategory = $this->_model->listCategory($this->_arrParam);
        $this->_view->listCategory = $listCategory;

        // pagination
        $totalItem = $this->_model->countItem($this->_arrParam);
        $configPagination = array('totalItemsPerPage'    => 8, 'pageRange' => 3);
        $this->setPagination($configPagination);
        $this->_view->pagination = new Pagination($totalItem, $this->_pagination);

        if (isset($this->_arrParam['category_id'])) {
            $this->_view->items = $this->_model->listItems($this->_arrParam, ['task' => 'book-in-cats']);
        } else {
            $this->_view->items = $this->_model->listItems($this->_arrParam, ['task' => 'list-all-books']);
        }

        $this->_view->specialBooks = $this->_model->listItems($this->_arrParam, ['task' => 'special-books']);

        $this->_view->render($this->_arrParam['controller'] . '/list');
    }

    public function detailAction()
    {
        $bookInfo = $this->_model->infoItem($this->_arrParam);
        if (empty($bookInfo)) URL::redirect($this->_arrParam['module'], 'index', 'notice', ['type' => 'not-url']);
        
        $this->_view->_title = "<title>{$bookInfo['name']}</title>";

        $this->_view->bookInfo = $bookInfo;
        $this->_arrParam['category_id'] = $bookInfo['category_id'];
        $this->_view->relatedBooks = $this->_model->listItems($this->_arrParam, ['task' => 'related-books']);

        $this->_view->specialBooks = $this->_model->listItems($this->_arrParam, ['task' => 'special-books']);
        $this->_view->newBooks = $this->_model->listItems($this->_arrParam, ['task' => 'new-books']);
        $this->_view->render($this->_arrParam['controller'] . '/detail');
    }

    public function ajaxQuickViewAction()
    {
        $result = $this->_model->infoItem($this->_arrParam);

        $pictureURL = HelperFrontend::createPictureURL($result['picture'], $this->_arrParam);
        $detailItem = URL::createLinkBookForUser($result, $this->_arrParam);

        $result['pictureURL'] = $pictureURL;
        $result['detailItem'] = $detailItem;
        $result['linkToCart'] = URL::createLink($this->_arrParam['module'], 'index', 'order');
        echo json_encode($result);
    }
}
