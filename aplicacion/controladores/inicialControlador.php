<?php
	 
     //Controlador con acciones respectivas a la página principal
	class inicialControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto="principal";
        }


        //Acción para mostrar la página de index
		public function accionPrincipal(){
            $this->dibujaVista("index",array(),"Indice de la aplicación");
		}

		
	}