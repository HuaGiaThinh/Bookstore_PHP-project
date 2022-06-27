<?php
class CategoryModel extends Model
{
    private $arrAcceptSearchField = ['name'];
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);
        $this->_uploadObj    = new Upload();
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

        // Filter group acp
        if (isset($params['group_acp']) && $params['group_acp'] != 'default') $query[] = "AND `group_acp` = '{$params['group_acp']}'";

        $query        = implode(" ", $query);
        $result = $this->singleRecord($query);
        return $result;
    }

    public function listItems($params)
    {
        $query[]     = "SELECT `id`, `name`, `picture`, `status`, `created`, `created_by`, `modified`, `modified_by`";
        $query[]     = "FROM `{$this->table}`";
        $query[]    = "WHERE `id` > 0";

        // Search
        $searchValue = isset($params['search']) ? trim($params['search']) : '';
        if (!empty($searchValue)) {
            $query[] = "AND {$this->createSearchQuery($searchValue)}";
        }

        // Filter Status
        if (isset($params['status']) && $params['status'] != 'all') $query[] = "AND `status` = '{$params['status']}'";

        // PAGINATION
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

        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }

    public function singleItem($params)
    {
        $query[]     = "SELECT `id`, `name`, `picture`, `status`";
        $query[]     = "FROM `{$this->table}`";
        $query[]     = "WHERE `id` = {$params['id']}";
        $query        = implode(" ", $query);

        $result        = $this->singleRecord($query);
        return $result;
    }

    public function handleStatus($params, $option = null)
    {
        if ($option['task'] == 'change-status') {
            $status = ($params['status'] == 'active') ? 'inactive' : 'active';

            $this->update(['status' => $status], [['id', $params['id']]]);
            return HelperBackend::showItemStatus($params['id'], $status, $params);
        }

        if ($option['task'] == 'change-groupACP') {
            $groupACP = ($params['group_acp'] == 0) ? 1 : 0;

            $this->update(['group_acp' => $groupACP], [['id', $params['id']]]);
            return HelperBackend::showItemGroupACP($params['id'], $groupACP, $params);
        }
    }

    public function deleteItems($params)
    {
        if (!empty($params['cid'])) {
            $this->delete($params['cid']);
        } else {
            $item = $this->singleItem($params);
            $this->_uploadObj->removeFile('category', $item['picture']);
            $this->delete([$params['id']]);
        }
        Session::set('message', 'Dữ liệu đã được xóa thành công!');
    }

    public function addItem($params, $userInfo)
    {
        $data = $params['form'];
        $data['picture']        = $this->_uploadObj->uploadFile($data['picture'], 'category');
        $data['created']        = date("Y:m:d H:i:s");
        $data['created_by']     = $userInfo['username'];
        $this->insert($data);
        Session::set('message', 'Thêm phần tử thành công!');
    }

    public function updateItem($params, $userInfo)
    {
        $data = $params['form'];

        if (isset($data['picture'])) {
            $item = $this->singleItem($params);
            $this->_uploadObj->removeFile('category', $item['picture']);
            $data['picture']        = $this->_uploadObj->uploadFile($data['picture'], 'category');
        }
        
        $data['modified']       = date("Y:m:d H:i:s");
        $data['modified_by']    = $userInfo['username'];
        $this->update($data, [['id', $params['id']]]);
        Session::set('message', 'Cập nhật phần tử thành công!');
    }
}
