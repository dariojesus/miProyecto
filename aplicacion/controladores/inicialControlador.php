<?php
	 
	class inicialControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto="principal";
        }


		public function accionPrincipal(){
            $this->dibujaVista("index",array(),"Indice de la aplicación");
		}

		
	}