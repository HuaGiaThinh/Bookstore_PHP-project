<?php
class GroupModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
	}

	public function listItems($params)
	{
		$searchValue = isset($params['search']) ? trim($params['search']) : '';

		$query[] 	= "SELECT `id`, `name`, `group_acp`, `status`, `created`, `created_by`, `modified`, `modified_by`";
		$query[] 	= "FROM `{$this->table}`";
		if (!empty($searchValue)) $query[] = " WHERE `name` LIKE '%$searchValue%'";
		$query		= implode(" ", $query);

		$result		= $this->listRecord($query);
		return $result;
	}

	public function singleItem($params)
	{
		$query[] 	= "SELECT `id`, `link`, `status`, `ordering`";
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
}
