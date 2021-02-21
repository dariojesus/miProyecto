<?php
	 
     //Controlador con acciones respectivas a la cuenta
	class gestionControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="crudUsuarios";
        }

        public function accionCrudUsuarios(){

            $usuarios = new Registro();
            $usuarios = $usuarios->buscarTodos();

            echo $this->dibujaVistaParcial("crudUsuarios",["usr"=>$usuarios],true).PHP_EOL;
        }

        public function accionMostrar(){

            $usuarios = new Registro();
            $exito = $usuarios->buscarPorId($_GET["codigo"]);

            if (!$exito){
                Sistema::app()->paginaError(505,"Ups, no se ha podido recuperar la información de dicho usuario.");
                return;
            }

            echo $this->dibujaVistaParcial("infoUsuarios",array(),true).PHP_EOL;
        }
	
	}