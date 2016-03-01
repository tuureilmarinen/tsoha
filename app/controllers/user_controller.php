<?php
require_once 'app/models/user.php';
require_once 'app/models/group.php';
class UserController extends BaseController{
	public static function create(){
		View::make("user/new.html");
	}
	public static function destroy($id){
		User::destroy($id);
	}
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
	public static function index(){
		if(parent::is_admin())
			View::make("user/index.html",array('users'=>User::all()));
		else
			Redirect::to("/", array('message' => "You are not an admin! ".parent::get_user_logged_in()->id));	
	}
	public static function store(){
		$user=User::store();
		if(!$user){
			Redirect::to("/", array('message' => "Failed to store user."));
		}
		Redirect::to("/", array('message' => "Saved user."));
	}
	public static function destroy($id){
		if(parent::is_admin() || parent::get_user_logged_in()->id==$id){
			User::destroy($id);
			Redirect::to("/")
		} else {
			Redirect::to("/", array('message' => "You are not an admin or user# ".$id));
		}
	}
}