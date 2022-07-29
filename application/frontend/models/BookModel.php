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
        if ($option['task'] == 'list-all-books') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]     = "AND `b`.`status` = 'active'";

            // sort
            if (isset($params['sort'])) {
                $query[] = $this->sort($params['sort']);
            } else {
                $query[]     = "ORDER BY `b`.`ordering` ASC";
            }

            //PAGINATION
            $pagination           = $params['pagination'];
            $totalItemsPerPage    = $pagination['totalItemsPerPage'];
            if ($totalItemsPerPage > 0) {
                $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'book-in-cats') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]     = "AND `b`.`status` = 'active'";
            $query[]     = "AND `b`.`category_id` = '{$params['category_id']}'";

            // sort
            if (isset($params['sort'])) {
                $query[] = $this->sort($params['sort']);
            } else {
                $query[]     = "ORDER BY `b`.`ordering` ASC";
            }

            //PAGINATION
            $pagination           = $params['pagination'];
            $totalItemsPerPage    = $pagination['totalItemsPerPage'];
            if ($totalItemsPerPage > 0) {
                $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'related-books') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]    = "AND `b`.`status` = 'active'";
            $query[]    = "AND `category_id` = '{$params['category_id']}'";
            $query[]    = "AND `b`.`id` <> '{$params['book_id']}'";
            $query[]    = "ORDER BY `b`.`ordering` ASC";
            $query[]    = "LIMIT 0, 6";

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'special-books') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]    = "AND `b`.`status` = 'active'";
            $query[]    = "AND `special` = 1";
            $query[]    = "ORDER BY `b`.`ordering` ASC";
            $query[]    = "LIMIT 0, 8";

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'new-books') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]    = "AND `b`.`status` = 'active'";
            $query[]    = "ORDER BY `b`.`id` DESC";
            $query[]    = "LIMIT 0, 6";

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }
    }

    private function sort($sort)
    {
        $sort = $sort;
        $price = "`price` - ((`price`*`sale_off`)/100)";

        switch ($sort) {
            case 'price_asc':
                $query[] = "ORDER BY $price ASC";
                break;
            case 'price_desc':
                $query[] = "ORDER BY $price DESC";
                break;
            case 'latest':
                $query[] = "ORDER BY `b`.`id` DESC";
                break;
            default:
                $query[] = "ORDER BY `b`.`ordering` ASC";
                break;
        }
        return $query[0];
    }
    public function infoItem($params, $option = null)
    {
        if ($option == null) {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]     = "AND `b`.`status` = 'active' AND `b`.`id` = '{$params['book_id']}'";

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

    public function countItem($params)
    {
        $query[]    = "SELECT COUNT(`id`) AS `total`";
        $query[]    = "FROM `{$this->table}`";
        $query[]    = "WHERE `status` = 'active'";
        if (isset($params['category_id'])) $query[] = "AND `category_id` = '{$params['category_id']}'";

        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }
}
