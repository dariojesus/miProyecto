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

            $var = new Planetas();
            $var = $var->buscarTodos();
            $this->dibujaVista("destinos",array("planetas"=>$var),"Destinos disponibles");
        }

        public function accioninfoDestino(){

            if(isset($_GET["codigo"])){
                
                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $planeta = new Planetas();
                
                if (!$planeta->buscarPorId($codigo)){
                    Sistema::app()->paginaError(404,"No se ha encontrado el destino que estaba buscando.");
                    return;
                }
                else{
                    $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                    $datos = CGeneral::peticionCurl($url,"GET",array("destino"=>$planeta->nombre));
                    $datos = json_decode($datos,true);

                    $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$datos),$planeta->nombre);
                    return;
                }
            }
        }

		
	}