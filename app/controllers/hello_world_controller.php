<?php
require 'app/models/group.php';
  class HelloWorldController extends BaseController{

    public static function hello(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('hello.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      echo 'Hello World!';
    }
  }
