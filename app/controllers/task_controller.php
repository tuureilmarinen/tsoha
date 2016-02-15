<?php
require_once 'app/models/task.php';
class TaskController extends BaseController{
  public static function index(){
    // Haetaan kaikki taskit tietokannasta
    parent::check_logged_in();
    $tasks = Task::find_by_user(parent::get_user_logged_in()->id);
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
    $params['user_id']=parent::get_user_logged_in()->id;
    $task=new Task($params);
    $errors=$task->validate();
    if(!$errors){
    // Kutsutaan alustamamme olion save metodia, joka tallentaa olion tietokantaan
      $task->save();
    // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    //Redirect::to('/task/' . $task->id, array('message' => 'Task has been added!'));
      Redirect::to('/task', array('message' => 'Task has been added!'));
    } else {
      View::make('task/new.html', array('errors' => $errors, 'attributes' => $params));
    }
  }
  public static function show($id){
    $task = Task::find(intval($id));
    View::make('task/show.html', array('task' => $task));
  }
  public static function create(){
    View::make('task/new.html');
  }
  public static function edit($id){
    $task = Task::find($id);
    View::make('task/edit.html', array('attributes' => $task));
  }
  public static function update($id){
    $params = $_POST;


    $game = new Task($params);
    $errors = $task->errors();

    if(count($errors) > 0){
      View::make('task/edit.html', array('errors' => $errors, 'attributes' => $attributes));
    }else{
      $game->update();

      Redirect::to('/task/' . $game->id, array('message' => 'Task has been modified successfully.'));
    }
  }

  public static function destroy($id){
    Task::destroy($id);
    Redirect::to('/task', array('message' => 'Task has been removed.'));
  }
  /*public function destroy(){
    $task = new Task(array('id' => $this->id));
    $task->destroy();
    Redirect::to('/task', array('message' => 'Task has been removed.'));
  }*/
}