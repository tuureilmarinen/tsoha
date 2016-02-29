<?php
require 'app/models/group.php';
class GroupController extends BaseController{
	public static function create(){
		View::make("group/new.html");
	}
	public static function store(){
		$group=Group::store();
		if(!$group){
			View::make("group/new.html",array("errors"=>array("something went terribly wrong")));
		}
		else {
			Redirect::to("/group");
		}
	}
	public static function index(){
		parent::check_logged_in();
		$groups = Group::find_by_user(parent::get_user_logged_in()->id);
		View::make('group/all.html', array('groups' => $groups,'title'=>parent::get_user_logged_in()->username.'\'s groups'));
	}
	public static function show($id){
		parent::check_logged_in();
		$group = Group::find(intval($id));
		View::make('group/show.html', array('group' => $group,'title'=>'view group'));
	}
	public static function destroy($id){
		parent::check_logged_in();
		Group::destroy($id);
		Redirect::to('/group', array('message' => 'Group has been removed.'));
	}
}