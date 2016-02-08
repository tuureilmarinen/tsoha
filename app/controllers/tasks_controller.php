<?php
class TaskController extends BaseController{
  public static function index(){
    // Haetaan kaikki taskit tietokannasta
    $tasks = Task::all();
    // Renderöidään views/game kansiossa sijaitseva tiedosto index.html muuttujan $games datalla
    View::make('task/index.html', array('tasks' => $tasks));
  }
}