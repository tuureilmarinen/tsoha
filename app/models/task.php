<?php
require 'app/models/group.php';
class Task extends BaseModel{
  // Attribuutit
	public $id, $name, $description, $completed, $priority, $user_id, $created_at, $updated_at, $groups;
  // Konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
		$this->validators=array('validate_name','validate_description','validate_priority','validate_user');
	}
	public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM tasks');
    // Suoritetaan kysely
		$query->execute();
    // Haetaan kyselyn tuottamat rivit
		$rows = $query->fetchAll();
		$tasks = array();
    // Käydään kyselyn tuottamat rivit läpi
		foreach($rows as $row){
			$groups=array();
			$query=DB::connection()->prepare('SELECT groups.* FROM groups INNER JOIN task_to_groups ON task_to_groups.group_id=groups.id WHERE task_to_groups.task_id = :task_id');
			
			$query->execute(array('task_id' => $row['id']));
			while($g = $query->fetch()){
				$groups[]=new Group($g);
			}
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
			$tasks[] = new Task(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'user_id' => $row['user_id'],
				'description' => $row['description'],
				'completed' => $row['completed'],
				'priority' => $row['priority'],
				'created_at' => $row['created_at'],
				'updated_at' => $row['updated_at'],
				'groups' => $groups
				));
		}

		return $tasks;
	}
	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM tasks WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();
		if($row){
			$query=DB::connection()->prepare('SELECT groups.* FROM groups INNER JOIN task_to_groups ON task_to_groups.group_id=groups.id WHERE task_to_groups.task_id = :task_id');
			$groups = array();
			$query->execute(array('task_id' => $row['id']));
			while($grow = $query->fetch()){
				$groups[]=new Group(array($grow));
			}
			$task = new Task(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'user_id' => $row['user_id'],
				'description' => $row['description'],
				'completed' => $row['completed'],
				'priority' => $row['priority'],
				'created_at' => $row['created_at'],
				'updated_at' => $row['updated_at'],
				'groups' => $groups
				));
			return $task;
		}

		return null;
	}
	public static function find_by_user($user_id){
		    // Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
    // Suoritetaan kysely
		$query->execute(array('user_id' => $user_id));
    // Haetaan kyselyn tuottamat rivit
		$rows = $query->fetchAll();
		$tasks = array();
    // Käydään kyselyn tuottamat rivit läpi
		foreach($rows as $row){
			$groups=array();
			$query=DB::connection()->prepare('SELECT groups.* FROM groups INNER JOIN task_to_groups ON task_to_groups.group_id=groups.id WHERE task_to_groups.task_id = :task_id');
			
			$query->execute(array('task_id' => $row['id']));
			while($g = $query->fetch()){
				$groups[]=new Group($g);
			}
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
			$tasks[] = new Task(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'user_id' => $row['user_id'],
				'description' => $row['description'],
				'completed' => $row['completed'],
				'priority' => $row['priority'],
				'created_at' => $row['created_at'],
				'updated_at' => $row['updated_at'],
				'groups' => $groups
				));
		}

		return $tasks;
	}
	public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
		$query = DB::connection()->prepare('INSERT INTO tasks (id,name, description, completed, priority, user_id, created_at, updated_at)
			VALUES (DEFAULT, :name, :description, :completed, :priority, :user_id, now(), now()) RETURNING id;');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
		$query->execute(array('name' => $this->name,
			'description' => $this->description,
			'completed' => $this->completed,
			'priority' => $this->priority,
			'user_id' => $this->user_id));
		$row = $query->fetch();
		//var_dump($this);
		//var_dump($row);
		if(!$row){
			die("tietokantavirhe");
		}
		$this->id = $row['id'];
	}
	public static function destroy($id){
		$query=DB::connection()->prepare('DELETE FROM tasks WHERE id= :id');
		$query->execute(array('id' => $id));
	}
	public static function update($id){
		$query=DB::connection()->prepare('UPDATE tasks SET name = :name, description = :description, user_id = :user_id, completed = :completed, priority = :priority, updated_at=now() WHERE id=:id');
		$query->execute(array(
			'id' => $id,
			'name' => $_POST['name'],
			'user_id' => $_POST['user_id'],
			'description' => $_POST['description'],
			'completed' => $_POST['completed'],
			'priority' => $_POST['priority']));
	}

	public function validate(){
		$errors=array();
		foreach($this->validators as $validator){
			$newerrors=$this->{$validator}();
			$errors=array_merge($errors,$newerrors);
		}
		return $errors;
	}

	public function validate_name(){
		$errors = array();
		if($this->name == '' || $this->name == null){
			$errors[] = 'Nimi ei saa olla tyhjä!';
		}
		if(strlen($this->name) < 3){
			$errors[] = 'Nimen pituuden tulee olla vähintään kolme merkkiä!';
		}

		return $errors;
	}
	public function validate_description(){
		$errors=array();
		if($this->description == '' || $this->description == null){
			$errors[] = 'Description cannot be empty';
		}
		if(strlen($this->name) < 3){
			$errors[] = 'Description cannot be less than 3 characters.';
		}
		return $errors;
	}
	public function validate_user(){
		$errors=array();
		if(!is_numeric($this->user_id)){ //TODO: tarkista tietokannasta voiko userid olla muu kuin int
			$errors[]="UserID is invalid (".$this->user_id.")"; 
		}
		return $errors;
	}
	public function validate_priority(){
		$errors=array();
		if(!is_numeric($this->priority)){ //TODO: tarkista tietokannasta voiko userid olla muu kuin int
			$errors[]="priority must be integer"; 
		}
		return $errors;
	}
}