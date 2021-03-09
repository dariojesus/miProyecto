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

        //Acción para ver los vuelos correspondientes al destino
        public function accioninfoDestino(){

            $planeta = new Planetas();

            //Control de vuelos a patir de un código de destino
            if(isset($_GET["codigo"])){
                
                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                
                if (!$planeta->buscarPorId($codigo)){
                    Sistema::app()->paginaError(404,"No se ha encontrado el destino que estaba buscando.");
                    return;
                }
                else{

                    $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);

                    //Control del formulario para filtrar los resultados
                    if ($_POST){

                        $opciones = array("destino"=>$planeta->nombre);
        
                        if (!empty($_POST["compannia"]))
                            $opciones["compannia"] = CGeneral::addSlashes($_POST["compannia"]);
        
                        if (!empty($_POST["fecha"]))
                            $opciones["fecha"] = CGeneral::fechaMysqlANormal($_POST["fecha"]);

                        $dato = CGeneral::peticionCurl($url,"GET",$opciones);
                        $dato = json_decode($dato,true);
        
                        $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$dato),$planeta->nombre);
                        return;
                    }

                    
                    $datos = CGeneral::peticionCurl($url,"GET",array("destino"=>$planeta->nombre));
                    $datos = json_decode($datos,true);

                    $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$datos),$planeta->nombre);
                    return;
                }
            }
	}
}