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
