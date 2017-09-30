<?php 
include ("application/models/BaseModel.php");

class UserModel extends BaseModel{
	protected $_table="user";
	public function __construct() {
		parent::__construct($this->_table);
	}
	public function getUsers(){

		$sql = "select * from $this->table";

		$users = $this->db->getAll($sql);

		return $users;

	}
}