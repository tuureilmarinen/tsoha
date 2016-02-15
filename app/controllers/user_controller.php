<?php
require 'app/models/user.php';
class UserController extends BaseController{
	public static function create(){
		View::make("user/new.html");
	}
	public static function destroy($id){
		User::destroy($id);
	}
	public static function store(){
		$user=User::store();
		if(!$user){
			
		}
	}
}