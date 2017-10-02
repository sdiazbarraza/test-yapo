<?php 
include ("application/models/BaseModel.php");

class UserModel extends BaseModel{
	protected $_table="user";
	protected  $_username;
	protected  $_password;
	protected  $_role;
	protected $arrayFields=array();
	public function __construct() {
		parent::__construct($this->_table);
	}
	public function getUsers(bool $isRead){
		if($isRead){
				$sql = "select username,roles  from $this->table";		
		}else{
				$sql = "select *  from $this->table";		
		}
		$users = $this->db->getAll($sql);

		return $users;
	}
	public function setFields(array $data){
		$this->arrayFields= array('username' => $data['username'],
								  'password' => $data['password'],
								  'roles' => $data['roles']	 );
	}
	private function setFieldsLogin(array $data){
		$this->_username=$data['username'];
		$this->_password=$data['password'];
	}
	public function checkUser(array $data){
		$this->setFieldsLogin($data);
		$sql = "select * from $this->table where username='{$this->_username}' and password='{$this->_password}'";
		$result = $this->db->getRow($sql);
		return $result;
	}
	public function save(array $data){
		$this->setFields($data);
		$result=null;
		if($this->isExistUser($data)==false){
	    	$result=$this->insert($this->arrayFields);
	    }	
		return $result;
	}
	public function toUpdate(array $data){
		
		return $this->update($data);
	}
	private function isExistUser($data){
		$sql = "select * from $this->table where username='{$data['username']}' and roles='{$data['roles']}'";
		$result = $this->db->getRow($sql);
		if(is_null($result)){
			return false;
		}else{
			return true;
		}
	}
}