<?php 

class LoadViewsController  extends BaseController{
	
	public function loginUser(){
		$this->loadView('header');
		$this->loadView('Login/form');
		$this->loadView('footer');
	}
	public function loadPage(){
		$this->loadView('header');
		$this->loadView('Login/page');
		$this->loadView('footer');
	}
	public function StartSession(){
		session_start();
		
	}

}