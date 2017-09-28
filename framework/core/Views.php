<?php 

class Views {
  	public static function render(string $view){
		
		require "application/views/".$view.".php";
	}

}