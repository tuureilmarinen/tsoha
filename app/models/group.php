<?php
class Group extends BaseModel{
  // Attribuutit
	public $id, $name, $user_id, $created_at, $updated_at;
  // Konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators=array("validate_name");
	}
	public function find_tasks(){
		$r=array();
		$query=DB::connection()->prepare("SELECT t.* FROM tasks AS t INNER JOIN ON task_to_groups AS tg ON tg.task_id=t.id INNER JOIN groups AS g ON tg.group_id=g.id WHERE g.id = :group_id");
		$query->execute(array('group_id' => $this->id));
		while($row = $query->fetch()){
			$r[]=new Task($row);	
		}
		return $r;
	}
	public static function task_count(){
		$query=DB::connection()->prepare("SELECT COUNT(*) FROM tasks AS t INNER JOIN task_to_groups AS tg ON t.id=tg.task_id INNER JOIN groups AS g ON tg.group_id=g.id WHERE g.id = :group_id");
		$query->execute(array('group_id' => $this->id));
		if($row = $query->fetch()){
				return $row[0];
		}
		return 0;
	}
	public static function all(){
		$r=array();
		$query=DB::connection()->prepare("SELECT * FROM groups");
		$query->execute();
		while($row = $query->fetch()){
			$r[]=new Group($row);		
		}
		return $r;
	}
	public static function find($id){
		$r=array();
		$query=DB::connection()->prepare("SELECT * FROM groups WHERE id = :group_id");
		$query->execute(array('group_id' => $id));
		$row = $query->fetch();
		if($row){
			return new Group($row);
		} else {
			return null;
		}
		
	}
	public static function find_by_user($user_id){
		$r=array();
		$query=DB::connection()->prepare("SELECT * FROM groups WHERE user_id = :user_id");
		$query->execute(array('user_id' => $user_id));
		while($row = $query->fetch()){
			$r[]=new Group($row);
		}
		if($r){
			return $r;
		} else {
			return null;
		}
		
	}
	public function user(){
		return User::find($this->user_id);
	}
	public function validate_name(){
		return (strlen($this->name)>3);
	}
	public static function store(){
		$query=DB::connection()->prepare('INSERT INTO users(id,name,user_id,updated_at,created_at) VALUES(DEFAULT, :name, :user_id, now(), now()) RETURNING id');
		$p=$_POST;
		$query->execute(array(
			'name' => $p['name'],
			'user_id' => get_user_logged_in()->id));
		$row=$query->fetch();
		if($row){
			return new User($row);
		}
		return null;
	}
}