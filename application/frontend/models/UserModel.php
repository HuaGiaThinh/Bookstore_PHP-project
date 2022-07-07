<?php
class UserModel extends Model
{
    private $arrAcceptSearchField = ['username', 'email', 'fullname'];
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);

        $user = Session::get('user');
        if (!empty($user)) $this->_userInfo = $user['info'];
    }

    private function createSearchQuery($value)
    {
        $result = '';
        foreach ($this->arrAcceptSearchField as $field) {
            $result .= " `$field` LIKE '%$value%' OR";
        }
        return  '(' . rtrim($result, ' OR') . ')';
    }

    public function listItems($params, $option = null)
    {
        if ($option['task'] == 'books-in-cart') {
            $cart = Session::get('cart');

            $result = [];
            if (!empty($cart)) {
                $ids = "(";
                foreach ($cart['quantity'] as $key => $value) $ids .= "'$key', ";
                $ids .= "'0')";

                $query[]    = "SELECT `id`, `name`, `picture`";
                $query[]    = "FROM `" . TBL_BOOK . "`";
                $query[]    = "WHERE `status` = 'active'";
                $query[]    = "AND `id` IN $ids";

                $query      = implode(" ", $query);
                $result     = $this->fetchAll($query);

                foreach ($result as $key => $value) {
                    $result[$key]['quantity']   = $cart['quantity'][$value['id']];
                    $result[$key]['totalPrice'] = $cart['price'][$value['id']];
                    $result[$key]['price']      = $result[$key]['totalPrice'] / $result[$key]['quantity'];
                }
            }
            return $result;
        }

        if ($option['task'] == 'order-history') {

            $query[]    = "SELECT `id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`";
            $query[]    = "FROM `" . TBL_CART . "`";
            $query[]    = "WHERE `username` = '{$this->_userInfo['username']}'";
            $query[]    = "ORDER BY `date` DESC";

            $query      = implode(" ", $query);
            $result     = $this->fetchAll($query);
            return $result;
        }
    }

    public function saveItems($params, $option = null)
    {
        if ($option['task'] == 'save-cart') {

            $id             = $this->randomString(10);
            $username       = $this->_userInfo['username'];
            $books          = json_encode($params['form']['book_id']);
            $prices         = json_encode($params['form']['price']);
            $quantities     = json_encode($params['form']['quantity']);
            $names          = json_encode($params['form']['name']);
            $names          = $this->escapeString($names);
            $pictures       = json_encode($params['form']['picture']);
            $date           = date("Y-m-d H:i:s");

            $query    = "INSERT INTO `" . TBL_CART . "`(`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`)
                VALUES ('$id', '$username', '$books', '$prices', '$quantities', '$names', '$pictures', '0', '$date')";

            $this->query($query);
            Session::delete('cart');

            $result['id'] = $id;

            return $result;
        }
    }

    public function infoItem($params, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `fullname`, `username`, `email`, `phone`, `address`";
            $query[]    = "FROM `{$this->table}`";
            $query[]    = "WHERE `id` = {$params['info']['id']}";

            $query      = implode(" ", $query);
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

    private function randomString($length = 7)
    {

        $arrCharacter = array_merge(range('a', 'z'), range(0, 9), range('A', 'Z'));
        $arrCharacter = implode('', $arrCharacter);
        $arrCharacter = str_shuffle($arrCharacter);

        $result        = substr($arrCharacter, 0, $length);
        return $result;
    }
}
