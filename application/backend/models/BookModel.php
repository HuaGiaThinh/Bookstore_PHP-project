<?php
class BookModel extends Model
{
    private $arrAcceptSearchField = ['name'];
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_BOOK);

        $this->_uploadObj    = new Upload();

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

    public function countItemByStatus($params)
    {
        $query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table` WHERE `id` > 0";

        // search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) $query[]  = "AND {$this->createSearchQuery($searchValue)}";

        // Filter group id
        if (isset($params['category_id']) && $params['category_id'] != 'default') $query[] = "AND `category_id` = '{$params['category_id']}'";

        $query        = implode(" ", $query);
        $result = $this->singleRecord($query);
        return $result;
    }

    public function listItems($params)
    {
        $query[]    = "SELECT `id`, `name`, `description`, `price`, `special`, `sale_off`, `picture`, `status`, `created`, `created_by`, `modified`, `modified_by`, `category_id`";
        $query[]    = "FROM `{$this->table}`";
        $query[]    = "WHERE `id` > 0";
        $query[]    = "ORDER BY `id` DESC";

        // Search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) {
            $query[] = "AND {$this->createSearchQuery($searchValue)}";
        }

        // Filter Status
        if (isset($params['status']) && $params['status'] != 'all') $query[] = "AND `status` = '{$params['status']}'";

        // Filter category id
        if (isset($params['category_id']) && $params['category_id'] != 'default') $query[] = "AND `category_id` = '{$params['category_id']}'";

        //PAGINATION
        $pagination           = $params['pagination'];
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

        // Filter category id
        if (isset($params['category_id']) && $params['category_id'] != 'default') $query[] = "AND `category_id` = '{$params['category_id']}'";

        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }

    public function singleItem($params)
    {
        $query[]    = "SELECT `id`, `name`, `description`, `price`, `special`, `sale_off`, `picture`, `status`, `created`, `created_by`, `modified`, `modified_by`, `category_id`";
        $query[]     = "FROM `{$this->table}`";
        $query[]     = "WHERE `id` = {$params['id']}";
        $query        = implode(" ", $query);

        $result        = $this->singleRecord($query);
        return $result;
    }

    public function getCategory($hasDefault = false)
    {
        $query        = "SELECT `id`, `name` FROM `category`";
        $list        = $this->listRecord($query);

        $result = [];
        if ($hasDefault) $result['default'] = 'Select Category';
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

        if ($option['task'] == 'change-bookSpecial') {
            $special = ($params['special'] == 1) ? 0 : 1;

            $this->update(['special' => $special], [['id', $params['id']]]);
            return HelperBackend::showItemBookSpecial($params['id'], $special, $params);
        }

        if ($option['task'] == 'change-category') {
            $this->update(['category_id' => $params['category_id']], [['id', $params['id']]]);
        }
    }

    public function deleteItems($params)
    {
        if (!empty($params['cid'])) {
            $this->delete($params['cid']);
        } else {
            $item = $this->singleItem($params);
            $this->_uploadObj->removeFile('book', $item['picture']);
            $this->delete([$params['id']]);
        }
        Session::set('message', 'Dữ liệu đã được xóa thành công!');
    }

    public function addItem($params, $option = null)
    {
        $data = $params['form'];

        $data['name']           = $this->escapeString($data['name']);
        $data['description']    = $this->escapeString($data['description']);
        $data['picture']        = $this->_uploadObj->uploadFile($data['picture'], 'book');
        $data['created']        = date("Y:m:d H:i:s");
        $data['created_by']     = $this->_userInfo['username'];
        $this->insert($data);
        Session::set('message', 'Thêm phần tử thành công!');
    }

    public function updateItem($params)
    {
        $data = $params['form'];

        if (isset($data['picture'])) {
            $item = $this->singleItem($params);

            $data['picture']        = $this->_uploadObj->uploadFile($data['picture'], 'book');
            $this->_uploadObj->removeFile('book', $item['picture']);
        }

        $data['name']           = $this->escapeString($data['name']);
        $data['description']    = $this->escapeString($data['description']);
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $this->_userInfo['username'];

        $this->update($data, [['id', $params['id']]]);
        Session::set('message', 'Cập nhật phần tử thành công!');
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
            $email    = $params['form']['email'];
            $password    = md5($params['form']['password']);
            $query[]    = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`";
            $query[]    = "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
            $query[]    = "WHERE `email` = '$email' AND `password` = '$password'";

            $query        = implode(" ", $query);
            $result        = $this->fetchRow($query);
            return $result;
        }
    }
}
