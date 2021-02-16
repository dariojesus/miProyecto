<?php

class CAcceso {

    private $_sesion;

    public function __construct(){
        $this->_sesion = new CSesion();
        $this->_sesion->crearSesion();

        $_SESSION["validado"] = false;
        $_SESSION["nif"] = "";
        $_SESSION["permisos"] = [];
    }

    public function registrarUsuario($nif, $permisos){
        $_SESSION["validado"] = true;
        $_SESSION["nif"] = $nif;
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

    public function getNif(){
        return $_SESSION["nif"];
    }
}

?>