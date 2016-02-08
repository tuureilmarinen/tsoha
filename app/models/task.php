<?php
class Task extends BaseModel{
  // Attribuutit
	public $id, $name, $user_id, $created_at, $updated_at;
  // Konstruktori
	public function __construct($attributes){
		parent::__construct($attributes);
	}
	public static function all(){
    // Alustetaan kysely tietokantayhteydellämme
		$query = DB::connection()->prepare('SELECT * FROM tasks');
    // Suoritetaan kysely
		$query->execute();
    // Haetaan kyselyn tuottamat rivit
		$rows = $query->fetchAll();
		$games = array();

    // Käydään kyselyn tuottamat rivit läpi
		foreach($rows as $row){
			$query=DB::connection()->prepare('SELECT groups.* FROM groups INNER JOIN task_to_groups ON task_to_groups.group_id=group.id WHERE task_to_groups.task_id = :task_id');
			$groups = array();
			$query->execute(array('task_id' => $row['id']));
			while($grow = $query->fetch()){
				$groups[]=new Group(array($grow));
			}
      // Tämä on PHP:n hassu syntaksi alkion lisäämiseksi taulukkoon :)
			$games[] = new Task(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'user_id' => $row['user_id'],
				'description' => $row['description'],
				'completed' => $row['completed'],
				'priority' => $row['priority'],
				'created_at' => $row['created_at'],
				'edited_at' => $row['edited_at'],
				'groups' => $groups
				));
		}

		return $games;
	}
	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM tasks WHERE id = :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();
		if($row){
			$game = new Task(array(
				'id' => $row['id'],
				'name' => $row['name'],
				'user_id' => $row['user_id'],
				'description' => $row['description'],
				'completed' => $row['completed'],
				'priority' => $row['priority'],
				'created_at' => $row['created_at'],
				'edited_at' => $row['edited_at']
				));
			$query=DB::connection()->prepare('SELECT groups.* FROM groups INNER JOIN task_to_groups ON task_to_groups.group_id=group.id WHERE task_to_groups.task_id = :task_id');
			$groups = array();
			$query->execute(array('task_id' => $row['id']));
			while($grow = $query->fetch()){
				$groups[]=new Group(array($grow));
			}
			return $game;
		}

		return null;
	}
	public function save(){
    // Lisätään RETURNING id tietokantakyselymme loppuun, niin saamme lisätyn rivin id-sarakkeen arvon
		$query = DB::connection()->prepare('INSERT INTO Task (name, description, completed, priority, user_id, created_at, edited_at)
			VALUES (:name, :description, :completed, :priority, :user_id, now(), now()) RETURNING id');
    // Muistathan, että olion attribuuttiin pääse syntaksilla $this->attribuutin_nimi
		$query->execute(array('name' => $this->name,
			'description' => $this->description,
			'completed' => $this->completed,
			'priority' => $this->priority,
			'user_id' => $this->user_id));
    // Haetaan kyselyn tuottama rivi, joka sisältää lisätyn rivin id-sarakkeen arvon
		$row = $query->fetch();
    // Asetetaan lisätyn rivin id-sarakkeen arvo oliomme id-attribuutin arvoksi
		$this->id = $row['id'];
	}
}