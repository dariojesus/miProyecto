<?php
	 
     //Controlador con acciones respectivas a la cuenta
	class gestionControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="crudUsuarios";
        }

        public function accionCrudUsuarios(){
            echo $this->dibujaVistaParcial("crudUsuarios",[],true).PHP_EOL;
        }
	
	}