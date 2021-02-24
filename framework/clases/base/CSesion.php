<?php

class CSesion{

    public function __construct(){
    }

    public function crearSesion(){
        session_start();          
    }

    public function haySesion(){
        return isset($_SESSION);
    }

    public function destruirSesion(){
        session_destroy();
    }
}


?>