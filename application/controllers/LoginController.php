<?php 
//amespace test-yapo\Application\Controllers;
use BaseController;

class LoginController  extends BaseController{
	 public static $userModel;
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