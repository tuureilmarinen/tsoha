<?php
require 'app/models/user.php';
class SessionController extends BaseController{
	public static function store(){
		session_start();
		$user=User::authenticate($_POST['user'],$_POST['password']);
		if($user){
			$_SESSION['user']=$user->id;
			Redirect::to("/tsoha/task",array('message' => "Welcome back, $user['name']."));
		}
		View::make('session/new.html', array('errors' => array("Wrong password or username.")));
	}
	public static function destroy(){
		session_start();
		$_SESSION['user']=null;
	}
	public static function create(){
		View::make('session/new.html');
	}
}