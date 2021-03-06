<?php
require_once 'app/models/task.php';
class TaskController extends BaseController{
  public static function index(){
    // Haetaan kaikki taskit tietokannasta
    parent::check_logged_in();
    $tasks = Task::find_by_user(parent::get_user_logged_in()->id);
    // Renderöidään views/task kansiossa sijaitseva tiedosto index.html muuttujan $tasks datalla
    View::make('task/index.html', array('tasks' => $tasks,'title'=>'my tasks'));
  }
  public static function store(){
    parent::check_logged_in();
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
      View::make('task/new.html', array('errors' => $errors, 'attributes' => $params,'title'=>'new task'));
    }
  }
  public static function show($id){
    parent::check_logged_in();
    $task = Task::find(intval($id));
    View::make('task/show.html', array('task' => $task,'title'=>'view task'));
  }
  public static function create(){
    parent::check_logged_in();
    $user=parent::get_user_logged_in();
    $id=$user->id;
    View::make('task/new.html',array('title'=>'new task','groups'=>Group::find_by_user($id)));
  }
  public static function edit($id){
    parent::check_logged_in();
    $user=parent::get_user_logged_in();
    $id=$user->id;
    $task = Task::find($id);
    View::make('task/edit.html', array('attributes' => $task,'title'=>'edit '.$task->name,'groups'=>Group::find_by_user($id)));
  }
  public static function update($id){
    parent::check_logged_in();
    $p = $_POST; // because i am a lazy piece of shit
    $task = Task::find($id);
    $task->name=$p['name'];
    $task->description=$p['description'];
    $task->priority=intval($p['priority']);
    $task->completed=(isset($p['completed'])? $p['completed'] : false);
    $errors = $task->validate();

    if(count($errors) > 0){
      View::make('task/edit.html', array('errors' => $errors, 'attributes' => $p,'title'=>'edit '.$task->name,'groups'=>Group::all()));
    }else{
      //$task->update();
      Task::update($id);
      Redirect::to('/task/' . $task->id, array('message' => 'Task has been modified successfully.'));
    }
  }

  public static function destroy($id){
    parent::check_logged_in();
    Task::destroy($id);
    Redirect::to('/task', array('message' => 'Task has been removed.'));
  }
  public static function markasdone($id){
    $u=parent::get_user_logged_in()->id;
    $t=Task::find($id);
    if($u==$t->user_id){
      $t->completed=true;
      $t->updateInstance();
    }
    Redirect::to('/task', array('message' => 'marked as done'));
  }
  public static function markasundone($id){
    $u=parent::get_user_logged_in()->id;
    $t=Task::find($id);
    if($u==$t->user_id){
      $t->completed=0;
      $t->updateInstance();
    }
    Redirect::to('/task', array('message' => 'marked as done'));
  }
  /*public function destroy(){
    $task = new Task(array('id' => $this->id));
    $task->destroy();
    Redirect::to('/task', array('message' => 'Task has been removed.'));
  }*/
}