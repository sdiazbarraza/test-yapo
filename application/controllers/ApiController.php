<?php 
require("BaseController.php");

class ApiController extends BaseController {
	protected $userModel;
	protected $authUser=array();
	protected $authPw=array();
	protected $authRole=array();
	protected $getUser=array();
	protected $allowRole=false;
	protected $key;
	public function __construct()
	{
		$this->userModel = $this->loadModel("UserModel");
		$this->getUser=$this->userModel->getUsers(false);
		
	} 	
	private function getAuthUser(){
		$this->getUser;
		foreach ($this->getUser as $key) {
			$this->authUser[]=$key['username'];
			$this->authPw[]=$key['password'];
			$this->authRole[]=$key['roles'];
		}
	}
	private function processHttpAuth(){
		$this->getAuthUser();
		if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])  && in_array($_SERVER['PHP_AUTH_USER'],$this->authUser)) {
			$this->key=array_search($_SERVER['PHP_AUTH_USER'],$this->authUser);
			if($_SERVER['PHP_AUTH_PW']==$this->authPw[$this->key]){
				$roleUser=$this->authRole[$this->key];
				if($roleUser=="ADMIN"){
					$this->allowRole=true;
				}
				return true;
			}else{
				header('WWW-Authenticate: Basic realm="Rest Api"');
				header('HTTP/1.0 404 Unauthorized');
				echo 'Text to send if user hits Cancel button';
				exit;
			}	
		} else {
			header('WWW-Authenticate: Basic realm="Rest Api"');
			header('HTTP/1.0 401 Unauthorized');
			echo 'Text to send if user hits Cancel button';
			exit;
		}
	}
	private function setParam($method){
		if($method!="GET"){
			$uri=$_SERVER['REQUEST_URI'];
			$contentType=$_SERVER['CONTENT_TYPE'];
			if($contentType=="application/json"){
				$content=	(array)json_decode(file_get_contents("php://input"));
			}else{
				parse_str(file_get_contents("php://input"),$parseval);
				$content=count($_POST)>0?$_POST:$parseval;
			}
			$varGet=explode("/",trim($uri));
			return array('_POST'=>$content,'_GET'=>array("iduser"=>isset($varGet[2])?$varGet[2]:0));	
		}
	}
	public function processData(){

		$arrayToReturn=array('data'=>'','status'=>'','msg'=>'');
		if($this->processHttpAuth()){
			$method = $_SERVER['REQUEST_METHOD'];
			$param=$this->setParam($method);
			switch (true) {
				case 'GET'==$method:
				http_response_code(200);
				$resultResponse=$this->userModel->getUsers(true);
				$arrayToReturn=array('data'=>$resultResponse,'status'=>'ok','msg'=>'Show Entity	',);
				break;
				case 'POST'==$method && $this->allowRole==true:
				$resultResponse=$this->userModel->save($param['_POST']);
				http_response_code(201);
				$arrayToReturn=array('data'=>array('idCreated'=>$resultResponse),'status'=>'ok'	,'msg'=>'Entity Created');
				break;
				case 'PUT'==$method && $this->allowRole==true:
				$resultResponse=$this->userModel->update(array_merge($param['_POST'],$param['_GET']));	
				http_response_code(201);	
				$arrayToReturn=array('data'=>array('affectedRows'=>$resultResponse),'status'=>'	ok','msg'=>'Entity Updated');
				break;
				case 'DELETE'==$method && $this->allowRole==true:
				$resultResponse=$this->userModel->delete($param['_GET']);
				http_response_code(201);
				$arrayToReturn=array('data'=>array('affectedRows'=>$resultResponse),'status'=>'	OK','msg'=>'Entity deleted');
				break;
				case $this->allowRole==false:
				header('WWW-Authenticate: Basic realm="Rest Api"');
				header('HTTP/1.0 401 Unauthorized');
				$arrayToReturn=array('data'=>[],'status'=>'NOT_AUTHORIZED','msg'=>'User not authorized');
				exit;
				break;	
				default:
				die(METHOD_NOT_ALLOWED);
				break;

			}
		};
		die(json_encode($arrayToReturn));
	}
 }