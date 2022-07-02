<?php
class BookModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_BOOK);
    }

    public function listItems($params, $option = null)
    {
        if ($option['task'] == 'book-in-cats') {
            $query[]     = "SELECT `id`, `name`, `description`, `picture`, `price`, `sale_off`, `category_id`";
            $query[]     = "FROM `{$this->table}`";
            $query[]     = "WHERE `status` = 'active' AND `category_id` = '{$params['category_id']}'";
            $query[]     = "ORDER BY `ordering` ASC";
    
            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'related-books') {
            $query[]     = "SELECT `id`, `name`, `description`, `picture`, `price`, `sale_off`, `category_id`";
            $query[]    = "FROM `{$this->table}`";
            $query[]    = "WHERE `status` = 'active'";
            $query[]    = "AND `category_id` = '{$params['category_id']}'";
            $query[]    = "AND `id` <> '{$params['book_id']}'";
            $query[]    = "ORDER BY `ordering` ASC";
            $query[]    = "LIMIT 0, 6";
    
            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }
        
    }

    public function infoItem($params, $option = null)
    {
        if ($option == null) {
            $query[]     = "SELECT `id`, `name`, `description`, `picture`, `price`, `sale_off`, `category_id`";
            $query[]     = "FROM `{$this->table}`";
            $query[]     = "WHERE `status` = 'active' AND `id` = '{$params['book_id']}'";
    
            $query        = implode(" ", $query);
            $result        = $this->fetchRow($query);
            return $result;
        }
    }

    public function listCategory($params)
    {
        $query[]     = 'SELECT `id`, `name` FROM `' . TBL_CATEGORY . '`';
        $query[]     = "WHERE `status` = 'active'";
        $query[]     = "ORDER BY `ordering` ASC";

        $query       = implode(" ", $query);
        $result      = $this->fetchAll($query);
        return $result;
    }
}
