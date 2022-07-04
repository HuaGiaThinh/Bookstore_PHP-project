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
            $categoryID = isset($params['category_id']) ? $params['category_id'] : $params['category_default'];

            $query[]     = "SELECT `id`, `name`, `description`, `picture`, `price`, `sale_off`, `category_id`";
            $query[]     = "FROM `{$this->table}`";
            $query[]     = "WHERE `status` = 'active' AND `category_id` = '$categoryID'";
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

        if ($option['task'] == 'special-books') {
            $query[]     = "SELECT `id`, `name`, `picture`, `price`, `sale_off`";
            $query[]    = "FROM `{$this->table}`";
            $query[]    = "WHERE `status` = 'active'";
            $query[]    = "AND `special` = 1";
            $query[]    = "ORDER BY `ordering` ASC";
            $query[]    = "LIMIT 0, 8";

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'new-books') {
            $query[]     = "SELECT `id`, `name`, `picture`, `price`, `sale_off`";
            $query[]    = "FROM `{$this->table}`";
            $query[]    = "WHERE `status` = 'active'";
            $query[]    = "ORDER BY `id` DESC";
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

        if ($option['task'] == 'login') {
            $email        = $params['form']['email'];
            $password    = md5($params['form']['password']);
            $query[]    = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`";
            $query[]    = "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
            $query[]    = "WHERE `email` = '$email' AND `password` = '$password'";

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
