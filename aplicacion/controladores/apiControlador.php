<?php
	 
     //Controlador con acciones respectivas a la API
	class apiControlador extends CControlador{

        private $_bd;

        public function __construct(){
            $this->_bd = Sistema::app()->BD();
        }
        
        public function accionVuelos(){
        }
	}