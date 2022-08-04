<?php
class IndexModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    public function listItems($params, $option = null)
    {
        if ($option['task'] == 'special-books') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]     = "AND `b`.`status` = 'active' AND `b`.`special` = 1";
            $query[]     = "ORDER BY `b`.`ordering` ASC";
            $query[]     = "LIMIT 0, 6";

            $query        = implode(" ", $query);
            $result        = $this->fetchAll($query);
            return $result;
        }

        if ($option['task'] == 'top-category') {
            $query[]     = "SELECT `id`, `name`";
            $query[]     = "FROM `" . TBL_CATEGORY . "`";
            $query[]     = "WHERE `status` = 'active' AND `show_at_home` = 1";
            $query[]     = "ORDER BY `ordering` ASC";
            $query[]     = "LIMIT 0, 3";

            $query        = implode(" ", $query);
            $result       = $this->fetchAll($query);

            foreach ($result as $key => $value) {
                $result[$key]['books'] = $this->listBooksInCate($value['id']);
            }
            return $result;
        }
    }

    public function infoItem($params, $option = null)
    {
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

        if ($option['task'] == 'quick-view-book') {
            $query[]     = HelperFrontend::createQueryBooks();
            $query[]     = "AND `b`.`status` = 'active' AND `b`.`id` = '{$params['book_id']}'";

            $query        = implode(" ", $query);
            $result        = $this->fetchRow($query);
            return $result;
        }
    }

    private function listBooksInCate($categoryID)
    {
        $query[]     = HelperFrontend::createQueryBooks();
        $query[]    = "AND `b`.`status` = 'active'";
        $query[]    = "AND `category_id` = '$categoryID'";
        $query[]     = "ORDER BY `b`.`ordering` ASC";
        $query[]     = "LIMIT 0, 8";

        $query        = implode(" ", $query);
        $result        = $this->fetchAll($query);
        return $result;
    }

    public function addItem($data)
    {
        $data['password']       = md5($data['password']);
        $data['group_id']       = 4;
        $data['status']         = 'active';
        $data['register_date']  = date("Y:m:d H:i:s");
        $data['register_ip']    = $_SERVER["REMOTE_ADDR"];

        $this->insert($data);
    }
}
