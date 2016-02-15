<?php
require 'app/models/user.php';
class SessionController extends BaseController{
	public static function create(){
		session_start();
		$user=User::authenticate($_POST['user'],$_POST['password']);
		$_SESSION['user']=$user->id;

	}
	public static function destroy(){
		session_start();
		$_SESSION['user']=null;
	}
	public static function new(){
		View::make('session/new.html');
	}