<?php 
class LoginController  extends BaseController{
	
	
	public function LoginUser(){
		$this->loadView('header');
		$this->loadView('Login/form');
		$this->loadView('footer');
	}
}