<?php
require 'app/models/group.php';
class GroupController extends BaseController{
	public static function create(){
		View::make("group/new.html");
	}
	public static function destroy($id){
		Group::destroy($id);
	}
	public static function store(){
		$group=Group::store();
		if(!$group){
			
		}
	}
	public static function index(){
		parent::check_logged_in();
		$groups = Group::find_by_user(parent::get_user_logged_in()->id);
		View::make('group/all.html', array('groups' => $groups,'title'=>'my groups'));
	}
	public static function show($id){
		parent::check_logged_in();
		$group = Group::find(intval($id));
		View::make('group/show.html', array('task' => $task,'title'=>'view group'));
	}
}