<?php 

class LoadViewsController  extends BaseController{
 	protected $arrayPage;
	public function __construct()
	{
		$this->arrayPage=array('page_1' =>'PAGE_1',
 					 		   'page_2' =>'PAGE_2',
 					 		   'page_3' =>'PAGE_3',
 					 		   'page' =>'ADMIN'
 							  );
		
	}
	public function loginUser(){
		$this->loadView('header');
		$this->loadView('Login/form');
		$this->loadView('footer');
	}
	public function loadPage(){
		session_start();
		if(isset($_SESSION['username']) && isset($_SESSION['roles'])){
			$username= $_SESSION['username'];
			$now=time();
			if($now > $_SESSION['expire']){
				echo "Session Expired";
				header('Refresh: 3; URL=/');
			}else{	
				$keyAp=str_replace("/","",$_SERVER['REQUEST_URI']);
				if($this->arrayPage[$keyAp]==$_SESSION['roles']){
					$this->loadView('header');
					$this->loadView('Login/page');
					$this->loadView('footer');
				}else{
					header('HTTP/1.0 401 Unauthorized');
					echo "ERROR 401 Unauthorized";
					$page=array_search($_SESSION['roles'],$this->arrayPage);
					if($page==false){
						header('Refresh: 2; URL=/'.$page);
					}	
				}
				
			}		
			
		}else{
			header('Location:/');
		}
		
	}
}