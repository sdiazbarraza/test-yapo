<?php 
 //include("framework/helper/SubString.php");
class Model {
	public static function loadModel($modelName){
		$pahtFile="application/models/".$modelName.".php";
		if(file_exists($pahtFile)){
			require_once($pahtFile);
			return 	new $modelName;		
		}else{
			 die('Cannot create new "'.$modelName.'" class - includes not found or class unavailable.');
		}
	}

}