<?php

class CAcceso {

    private $_sesion;
    private $_validado;
    private $_nif;
    private $_permisos;

    public function __construct(){

        $this->_sesion = new CSesion();
        $this->_validado = false;

        if (!$this->_sesion->haySesion()){
            $this->_sesion->crearSesion();
            $this->_nif = "";
            $this->_permisos = [];
            $this->_validado = false;
            $_SESSION["nif"] = $this->_nif;
            $_SESSION["permisos"] = $this->_permisos;
        }
    }

    public function registrarUsuario($nif, $permisos){
        if ($nif == "")
            $this->_validado = false;
        else
            $this->_validado = true;

        $this->_nif= $nif;
        $this->_permisos = $permisos;
        $_SESSION["nif"] = $nif;
        $_SESSION["permisos"] = $permisos;
    }

    public function quitarRegistroUsuario(){
        $this->_validado = false;
        $this->_nif = "";
        $this->_permisos = "";
        $_SESSION["nif"] = "";
        $_SESSION["permisos"] = "";

    }
    
    public function hayUsuario(){
        return  $this->_validado;
    }
    
    public function puedePermisos($numero){

        if (!isset($this->_permisos["permiso".$numero]))
            return false;

        return $this->_permisos["permiso".$numero] == "1";
    }

    public function getNif(){
        return $this->_nif;
    }
}

?>