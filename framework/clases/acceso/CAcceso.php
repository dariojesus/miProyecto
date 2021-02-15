<?php

class CAcceso {

    private $_sesion;

    public function __construct(){
        $this->_sesion = new CSesion();
        $this->_sesion->crearSesion();

        $_SESSION["validado"] = false;
        $_SESSION["nick"] = "";
        $_SESSION["nombre"] = "";
        $_SESSION["permisos"] = [];
    }

    public function registrarUsuario($nick, $nombre, $permisos){
        $_SESSION["validado"] = true;
        $_SESSION["nick"] = $nick;
        $_SESSION["nombre"] = $nombre;
        $_SESSION["permisos"] = $permisos;
    }

    public function quitarRegistroUsuario(){
        $_SESSION["validado"] = false;
    }
    
    public function hayUsuario(){
        return $_SESSION["validado"];
    }
    
    public function puedePermisos($numero){
        return $_SESSION["permisos"]["permiso".$numero] == "1";
    }

    public function getNick(){
        return $_SESSION["nick"];
    }

    public function getNombre(){
        return $_SESSION["nombre"];
    }
}

?>