<?php 
class ProcessLoginController extends BaseController {
	protected $userModel;
	protected $getUser=array();
	protected $allowRole=false;
	protected $key;
	public function __construct()
	{
		$this->userModel = $this->loadModel("UserModel");
		$this->getUser=$this->userModel->getUsers(false);
	} 	
	public  function processLogin(){
		$resultData=$this->userModel->checkUser($_POST);
		if($resultData!=FALSE){
			$this->generateSession($resultData);
			switch ($_SESSION["roles"]) {
				case 'PAGE_1':
				header('Location:/page_1');
				break;
				case 'PAGE_2':
				header('Location:/page_2');
				break;
				case 'PAGE_3':
				header('Location:/page_3');
				break;	
				default:
				header('Location:/page');
				break;
			}
			
		}else{
			echo "Data not Found";
			header('Refresh: 3; URL=/');
     		//$this->loadView("error");
		};
	}
	public  function processLogout(){
		session_start();
		$boolSession=session_destroy();
		if($boolSession){
			header('Location:/');
		}
	}
	public function generateSession(array $data){
		session_start();	
		$_SESSION["username"]=$data["username"];
		$_SESSION["roles"]=$data["roles"];
		$_SESSION["time"]=time();
		$_SESSION["expire"]=$_SESSION["time"]+(5*60);
	}

	
 }