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
		if (!empty($searchValue)) $query[]    = "WHERE {$this->createSearchQuery($searchValue)}";
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
		if ($option['task'] == 'change-ajax-status') {
			$status = ($params['status'] == 'active') ? 'inactive' : 'active';
			$id = $params['id'];

			$query	= "UPDATE `$this->table` SET `status` = '$status' WHERE `id` = '" . $id . "'";
			$this->query($query);

			$result =  [$id, $status, URL::createLink('backend', 'group', 'ajaxStatus', [
				'id' => $id, 'status' => $status
			])];
			return $result;
		}

		if ($option['task'] == 'change-ajax-ACP') {
			$groupACP = ($params['group_acp'] == 0) ? 1 : 0;
			$id = $params['id'];

			$query	= "UPDATE `$this->table` SET `group_acp` = $groupACP WHERE `id` = '" . $id . "'";
			$this->query($query);

			$result =  [$id, $groupACP, URL::createLink('backend', 'group', 'ajaxACP', [
				'id' => $id, 'group_acp' => $groupACP
			])];
			return $result;
		}

		if ($option['task'] == 'change-status') {
			$status = $params['type'];

			if (!empty($params['cid'])) {
				$ids = $this->createWhereDeleteSQL($params['cid']);
				$query	= "UPDATE `$this->table` SET `status` = $status WHERE `id` IN ($ids)";
				$this->query($query);
			}
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
