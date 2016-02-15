<?php
require 'app/models/task.php';
class TaskController extends BaseController{
  public static function index(){
    // Haetaan kaikki taskit tietokannasta
    $tasks = Task::all();
    // Renderöidään views/task kansiossa sijaitseva tiedosto index.html muuttujan $tasks datalla
    View::make('task/index.html', array('tasks' => $tasks));
  }
  public static function store(){
    // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
    $params = $_POST;
    // Alustetaan uusi task-luokan olion käyttäjän syöttämillä arvoilla
    /*$task = new task(array(
      'name' => $params['name'],
      'description' => $params['description'],
      'publisher' => $params['publisher'],
      'published' => $params['published']
      ));*/
$task=new Task($params);

if($task->validate()==0){
    // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
  $task->save();

    // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    //Redirect::to('/task/' . $task->id, array('message' => 'Task has been added!'));
  Redirect::to('/task', array('message' => 'Task has been added!'));
} else {
  View::make('task/new.html', array('errors' => $errors, 'attributes' => $attributes));
}

}
public static function show($id){
 $task = Task::find(intval($id));
 View::make('task/show.html', array('task' => $task));
}
public static function create(){
  View::make('task/new.html');
}
}