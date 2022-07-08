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

        $this->_arrParam['category_default'] = $listCategory[0]['id'];
        $this->_view->items = $this->_model->listItems($this->_arrParam, ['task' => 'book-in-cats']);

        $this->_view->specialBooks = $this->_model->listItems($this->_arrParam, ['task' => 'special-books']);
        $this->_view->categoryDefault = $this->_arrParam['category_default'];
        $this->_view->render($this->_arrParam['controller'] . '/list');
    }

    public function detailAction()
    {
        $bookInfo = $this->_model->infoItem($this->_arrParam);
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
        $detailItem = URL::createLink($this->_arrParam['module'], $this->_arrParam['controller'], 'detail', ['book_id' => $result['id']]);

        $result['pictureURL'] = $pictureURL;
        $result['detailItem'] = $detailItem;
        $result['linkToCart'] = URL::createLink($this->_arrParam['module'], 'user', 'order');
        echo json_encode($result);
    }
}
