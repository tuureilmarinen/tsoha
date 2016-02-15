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
			$r[]=new Task($row);	// toimiikohan?		
		}
		return $r;
	}
	public static function all(){
		$r=array();
		$query=DB::connection()->prepare("SELECT * FROM groups");
		$query->execute();
		while($row = $query->fetch()){
			$r[]=new Group($row);	// toimiikohan?		
		}
		return $r;
	}
	public static find($id){
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
}