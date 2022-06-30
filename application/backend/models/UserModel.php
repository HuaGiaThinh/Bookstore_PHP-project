<?php
class UserModel extends Model
{
    private $arrAcceptSearchField = ['username', 'email', 'fullname'];
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);

        $user = Session::get('user');
        $this->_userInfo = $user['info'];
    }

    private function createSearchQuery($value)
    {
        $result = '';
        foreach ($this->arrAcceptSearchField as $field) {
            $result .= " `$field` LIKE '%$value%' OR";
        }
        return  '(' . rtrim($result, ' OR') . ')';
    }

    public function countItemByStatus($params)
    {
        $query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table` WHERE `id` > 0";

        // search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) $query[]    = "AND {$this->createSearchQuery($searchValue)}";

        // Filter group id
        if (isset($params['group_id']) && $params['group_id'] != 'default') $query[] = "AND `group_id` = '{$params['group_id']}'";

        $query        = implode(" ", $query);
        $result = $this->singleRecord($query);
        return $result;
    }

    public function listItems($params)
    {
        $query[]    = "SELECT `id`, `username`, `email`, `status`, `fullname`, `created`, `created_by`, `modified`, `modified_by`, `group_id`";
        $query[]    = "FROM `{$this->table}`";
        $query[]    = "WHERE `id` > 0";

        // Search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) {
            $query[] = "AND {$this->createSearchQuery($searchValue)}";
        }

        // Filter Status
        if (isset($params['status']) && $params['status'] != 'all') $query[] = "AND `status` = '{$params['status']}'";

        // Filter group id
        if (isset($params['group_id']) && $params['group_id'] != 'default') $query[] = "AND `group_id` = '{$params['group_id']}'";

        //PAGINATION
        $pagination            = $params['pagination'];
        $totalItemsPerPage    = $pagination['totalItemsPerPage'];
        if ($totalItemsPerPage > 0) {
            $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
            $query[]    = "LIMIT $position, $totalItemsPerPage";
        }

        $query        = implode(" ", $query);
        $result        = $this->listRecord($query);
        return $result;
    }

    public function countItem($params)
    {
        $query[]     = "SELECT COUNT(`id`) AS `total`";
        $query[]     = "FROM `{$this->table}`";
        $query[]    = "WHERE `id` > 0";

        // Search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) {
            $query[] = "AND {$this->createSearchQuery($searchValue)}";
        }

        // Filter Status
        if (isset($params['status']) && $params['status'] != 'all') $query[] = "AND `status` = '{$params['status']}'";

        // Filter group id
        if (isset($params['group_id']) && $params['group_id'] != 'default') $query[] = "AND `group_id` = '{$params['group_id']}'";

        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }

    public function singleItem($params)
    {
        $query[]    = "SELECT `id`, `username`, `email`, `status`, `fullname`, `created`, `created_by`, `modified`, `modified_by`, `group_id`";
        $query[]     = "FROM `{$this->table}`";
        $query[]     = "WHERE `id` = {$params['id']}";
        $query        = implode(" ", $query);

        $result        = $this->singleRecord($query);
        return $result;
    }

    public function getGroup($hasDefault = false)
    {
        $query        = "SELECT `id`, `name` FROM `group`";
        $list        = $this->listRecord($query);

        $result = [];
        if ($hasDefault) $result['default'] = '- Select Group -';
        foreach ($list as $value) {
            $result[$value['id']] = $value['name'];
        }
        return $result;
    }

    public function handleStatus($params, $option = null)
    {
        if ($option['task'] == 'change-status') {
            $status = ($params['status'] == 'active') ? 'inactive' : 'active';

            $this->update(['status' => $status], [['id', $params['id']]]);
            return HelperBackend::showItemStatus($params['id'], $status, $params);
        }

        if ($option['task'] == 'change-group') {
            $this->update(['group_id' => $params['group_id']], [['id', $params['id']]]);
        }

        if ($option['task'] == 'change-groupACP') {
            $groupACP = ($params['group_acp'] == 0) ? 1 : 0;

            $this->update(['group_acp' => $groupACP], [['id', $params['id']]]);
            Session::set('message', 'Thay đổi group ACP thành công!');
        }
    }

    public function deleteItems($params)
    {
        if (!empty($params['cid'])) {
            $this->delete($params['cid']);
        } else {
            $this->delete([$params['id']]);
        }
        Session::set('message', 'Dữ liệu đã được xóa thành công!');
    }

    public function addItem($data)
    {
        $data['created'] = date("Y:m:d H:i:s");
        $data['created_by'] = $this->_userInfo['user'];
        $data['password'] = md5($data['password']);

        $this->insert($data);
        Session::set('message', 'Thêm phần tử thành công!');
    }

    public function updateItem($data, $id)
    {
        $data['modified']         = date("Y:m:d H:i:s");
        $data['modified_by']     = $this->_userInfo['user'];

        if ($data['password'] != null) {
            $data['password'] = md5($data['password']);
        } else {
            unset($data['password']);
        }
        $this->update($data, [['id', $id]]);
        Session::set('message', 'Cập nhật phần tử thành công!');
    }

    public function updateProfile($data)
    {
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $this->_userInfo['username'];

        $this->update($data, [['id', $this->_userInfo['id']]]);
        Session::set('message', 'Cập nhật thông tin thành công!');
    }

    public function changePassword($data)
    {
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $this->_userInfo['username'];

        if ($data['password'] != null) {
            $data['password'] = md5($data['password']);
            unset($data['old_password']);
            unset($data['confirm_password']);
        }

        $this->update($data, [['id', $this->_userInfo['id']]]);
        Session::set('message', 'Thay đổi mật khẩu thành công!');
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
}
