<?php
class Group extends BaseModel{
  // Attribuutit
	public $id, $name, $user_id, $created_at, $updated_at;
  // Konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
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
}