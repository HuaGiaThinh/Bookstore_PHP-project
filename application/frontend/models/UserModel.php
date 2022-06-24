<?php
class UserModel extends Model
{
    private $arrAcceptSearchField = ['username', 'email', 'fullname'];
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);
    }

    private function createSearchQuery($value)
    {
        $result = '';
        foreach ($this->arrAcceptSearchField as $field) {
            $result .= " `$field` LIKE '%$value%' OR";
        }
        return  '(' . rtrim($result, ' OR') . ')';
    }

    public function infoItem($params, $option = null)
    {
        $query[]    = "SELECT `id`, `fullname`, `username`, `email`, `phone`, `address`";
        $query[]    = "FROM `{$this->table}`";
        $query[]    = "WHERE `id` = {$params['info']['id']}";

        $query      = implode(" ", $query);
        $result        = $this->fetchRow($query);
        return $result;
    }

    public function getGroup($hasDefault = false)
    {
        $this->setTable(TBL_GROUP);
        $query        = "SELECT `id`, `name` FROM `{$this->table}`";
        $list        = $this->listRecord($query);

        $result = [];
        if ($hasDefault) $result['default'] = '- Select Group -';
        foreach ($list as $value) {
            $result[$value['id']] = $value['name'];
        }
        return $result;
    }

    public function updateItem($data, $user)
    {
        $userInfo = $user['info'];
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $userInfo['username'];

        $this->update($data, [['id', $userInfo['id']]]);
    }

    public function changePassword($data, $user)
    {
        
        $userInfo = $user['info'];
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $userInfo['username'];

        if ($data['password'] != null) {
            $data['password'] = md5($data['password']);
            unset($data['old_password']);
            unset($data['confirm_password']);
        }

        $this->update($data, [['id', $userInfo['id']]]);
    }
}
