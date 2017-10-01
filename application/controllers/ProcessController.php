<?php 
class ProcessController extends BaseController {
	protected $userModel;
	 public function __construct()
     {
     		$this->userModel = $this->loadModel("UserModel");
     		
     } 	

    public  function processLogin(){
    	$resultData=$this->userModel->checkUser($_POST);
     	if($resultData!=FALSE){
     		$this->generateSession($resultData);
     		header('Location:/page');
     	}else{
     		echo "Data not Found";
     		header('Refresh: 3; URL=/');
     		//$this->loadView("error");
     	};
     }

     public function generateSession(array $data){
     	session_start();	
     	$_SESSION["username"]=$data["username"];
     	$_SESSION["role"]=$data["roles"];
     }

     public function processRead(){
     	$result=$this->userModel->getUsers();
     	die(json_encode($result));
     }

     public function processCreate(){
     	$resultId=$this->userModel->save($_POST);
     	$arrayToReturn=array('id'=>$resultId,'status'=>http_response_code(201),'msg'=>'Created');
     	if($resultId===FALSE){
     		$arrayToReturn['status']=501;
     		$arrayToReturn['msg']='Internal Server Error';
     		$arrayToReturn['id']='Error';
     	}else if(is_null($resultId)){
     		$arrayToReturn['status']=http_response_code(409);
     		$arrayToReturn['msg']='Conflict';
     		$arrayToReturn['id']='Conflict';
     	}
     	die(json_encode($arrayToReturn));
     }
}