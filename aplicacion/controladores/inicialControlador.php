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

        //Acción para mostrar los planetas (destinos)
        public function accionDestinos(){

            $var = Sistema::app()->BD()->crearConsulta("SELECT * FROM destinos ORDER BY `nombre`");
            $var = $var->filas();

            for ($cont = 0; $cont < count($var); $cont++){

                $vue = Sistema::app()->BD()->crearConsulta("SELECT `cod_vuelo`".
                                                                  ",`fecha_salida`".
                                                                  ",`hora_salida`".
                                                                  ",`compannia`".
                                                                  ",`plazas`".
                                                                  ",`nombre`".
                                                                  " FROM vuelos_destinos".
                                                                  " WHERE `nombre` = '".$var[$cont]["nombre"]."'");
                $var[$cont]["vuelos"] = $vue->filas();
            }

            $this->dibujaVista("destinos",array("planetas"=>$var),"Destinos disponibles");
        }

		
	}