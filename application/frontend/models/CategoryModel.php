<?php
class CategoryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);
    }

    public function listItems($params)
    {
        $query[]     = "SELECT `id`, `name`, `picture`";
        $query[]     = "FROM `{$this->table}`";
        $query[]     = "WHERE `status` = 'active'";
        $query[]     = "ORDER BY `ordering` ASC";

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
    }

    public function countItem($params)
    {
        $query[]    = "SELECT COUNT(`id`) AS `total`";
        $query[]    = "FROM `{$this->table}`";
        $query[]    = "WHERE `status` = 'active'";

        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }
}
