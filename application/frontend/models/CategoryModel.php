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

    public function addItem($data)
    {
        $data['password'] = md5($data['password']);
        $data['group_id'] = 4;
        $data['status'] = 'inactive';
        $data['register_date'] = date("Y:m:d H:i:s");
        $data['register_ip'] = $_SERVER["REMOTE_ADDR"];

        $this->insert($data);
    }
}
