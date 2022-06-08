<?php
class GroupModel extends Model
{
	private $arrAcceptSearchField = ['name', 'status'];
	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
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
		$searchValue = isset($params['search']) ? trim($params['search']) : '';

		$query[] = "SELECT COUNT(`status`) as `all`, SUM(`status` = 'active') as `active`, SUM(`status` = 'inactive') as `inactive` FROM `$this->table`";
		if (!empty($searchValue)) $query[]    = "WHERE {$this->createSearchQuery($searchValue)}";

		$query		= implode(" ", $query);
		$result = $this->singleRecord($query);
		return $result;
	}

	public function listItems($params)
	{
		$searchValue = isset($params['search']) ? trim($params['search']) : '';

		$query[] 	= "SELECT `id`, `name`, `group_acp`, `status`, `created`, `created_by`, `modified`, `modified_by`";
		$query[] 	= "FROM `{$this->table}`";

		// Search
		if (!empty($searchValue)) $query[] = "WHERE {$this->createSearchQuery($searchValue)}";

		// Filter Status
		if (isset($params['status']) && $params['status'] != 'all') $query[] = "WHERE `status` = '{$params['status']}'";

		$query		= implode(" ", $query);

		$result		= $this->listRecord($query);
		return $result;
	}

	public function singleItem($params)
	{
		$query[] 	= "SELECT `id`, `name`, `group_acp`, `status`";
		$query[] 	= "FROM `{$this->table}`";
		$query[] 	= "WHERE `id` = {$params['id']}";
		$query		= implode(" ", $query);

		$result		= $this->singleRecord($query);
		return $result;
	}

	public function handleStatus($params, $option = null)
	{
		if ($option['task'] == 'change-status') {
			$status = ($params['status'] == 'active') ? 'inactive' : 'active';

			$this->update(['status' => $status], [['id', $params['id']]]);
			Session::set('message', 'Thay đổi trạng thái thành công!');
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
		$data['created_by'] = 'admin';
		$this->insert($data);
		Session::set('message', 'Thêm phần tử thành công!');
	}

	public function updateItem($data, $id)
	{
		$data['modified'] = date("Y:m:d H:i:s");
		$data['modified_by'] = 'admin';
		$this->update($data, [['id', $id]]);
		Session::set('message', 'Cập nhật phần tử thành công!');
	}
}
