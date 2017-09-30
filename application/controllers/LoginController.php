<?php 
class LoginController  extends BaseController{
	 protected $userModel;
	 public function __construct()
     {
     		$this->userModel = $this->loadModel("UserModel");
     		
     } 	
	public function LoginUser(){
		$this->loadView('header');
		$this->loadView('Login/form');
		$this->loadView('footer');
	}
}