<?php
require_once 'app/models/user.php';
require_once 'app/models/group.php';
class UserController extends BaseController{
	public static function create(){
		View::make("user/new.html");
	}
	/*public static function destroy($id){
		User::destroy($id);
	}*/
	public static function show($id){
		parent::check_logged_in();
		$user=parent::get_user_logged_in();
		$id=intval($id);
		if($user->id==$id || parent::is_admin()){
			$user_to_show=User::find($id);
			View::make('user/show.html', array('user' => $user_to_show,'title'=>"user: ".$user_to_show->username,'groups'=>Group::find_by_user($id)));
		} else {
			Redirect::to("/", array('message' => "You are not an admin or user# ".$id));
		}
		
	}
	public static function edit($id){
		parent::check_logged_in();
		$loggedin=parent::get_user_logged_in();
		$user=User::find($id);
		if(parent::is_admin() || $user->id==$loggedin->$id){
			View::make('user/edit.html', array('attributes' => $user,'title'=>"edit user"));
		} else {
			Redirect::to("/", array('message' => "You are not allowed to do that."));
		}
	}
	public static function index(){
		if(parent::is_admin()){
			View::make("user/index.html",array('users'=>User::all()));
		}
		else {
			Redirect::to("/", array('message' => "You are not an admin! ".parent::get_user_logged_in()->id));	
		}
	}
	public static function store(){
		$user=new User($_POST);
		$errors=$user->validate();
		if(!$user || count($errors)>0){
			//Redirect::to("/", array('message' => "Failed to store user."));
			View::make("user/new.html",array('message' => "Failed to store user.",'errors' => $errors));
		} else {
			$user->store();
			Redirect::to("/", array('message' => "Saved user."));
		}
	}
	public static function update($id){
		parent::check_logged_in();
		$c=parent::get_user_logged_in();
		$user=User::find($id);
		$user->password=$_POST['password'];
		$user->password_confirmation=$_POST['password_confirmation'];
		$user->username=$_POST['username'];
		if(parent::is_admin()){
			$user->admin=isset($_POST['admin']);
		} else {
			$user->admin=false;
		}
		@$errors=$user->validate();
		if(!$user || count($errors)>0){
			//Redirect::to("/", array('message' => "Failed to store user."));
			View::make("user/edit.html",$_POST);
		} else {
			$user->update();
			Redirect::to("/", array('message' => "updated user."));
		}
	}
	public static function destroy($id){
		if(parent::is_admin() || parent::get_user_logged_in()->id==$id){
			User::destroy($id);
			Redirect::to("/user", array('message' => "User was destroyed."));
		} else {
			Redirect::to("/", array('message' => "You are not an admin or user# ".$id));
		}
	}
}