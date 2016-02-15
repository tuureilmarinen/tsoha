<?php
require 'app/models/user.php';
class SessionController extends BaseController{
	public static function store(){
		$user=User::authenticate($_POST['username'],$_POST['password']);
		if($user){
			$_SESSION['user']=$user->id;
			Redirect::to("/task",array('message' => "Welcome back."));
		}
		View::make('session/new.html', array('errors' => array("Wrong password or username.")));
	}
	public static function destroy(){
		$_SESSION['user']=null;
	}
	public static function create(){
		View::make('session/new.html');
	}
}