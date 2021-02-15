<?php
	 
	class logueoControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="formulario";
        }

		public function accionFormulario(){
            echo $this->dibujaVistaParcial("index",array(),true).PHP_EOL;
		}

        public function accionRegistro(){
            echo $this->dibujaVistaParcial("registro",array(),true).PHP_EOL;
        }
		
	}