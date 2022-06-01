<?php
class GroupModel extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->setTable('group');
	}

	public function listItems($searchValue = null)
	{
		$query[] 	= "SELECT `id`, `name`, `group_acp`, `status`, `created`, `modified`";
		$query[] 	= "FROM `{$this->table}`";
		if (!empty($searchValue)) $query[] = " WHERE `link` LIKE '%$searchValue%'";
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
}
