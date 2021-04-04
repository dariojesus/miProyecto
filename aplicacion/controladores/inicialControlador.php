<?php
	 
     //Controlador con acciones respectivas a la página principal
	class inicialControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto="principal";
        }

        //Acción para mostrar la página de index
		public function accionPrincipal(){

            switch($_COOKIE["lang"]){
                    case("en"): 
                        $palabras = ["en","Don't you really want to travel to..?","Go ahead and buy one, there are a few remains",
                                     "Find your next destination"]; 
                        break;

                    default: 
                        $palabras = ["es","¿Seguro que no quieres viajar a..?","Corre que vuelan, quedan pocas plazas",
                                    "Encuentra tu próximo destino"];
                        break;
                }

            $this->dibujaVista("index",array("palabras"=>$palabras),"Indice de la aplicación");
		}

        //Acción para mostrar los planetas (destinos)
        public function accionDestinos(){

            switch($_COOKIE["lang"]){

                case("en"): $palabras = ["en","Trip duration: "," hours"];break;
                default: $palabras = ["es","Duración del viaje: "," horas"];break;
              }

            $var = new Planetas();
            $var = $var->buscarTodos();
            $this->dibujaVista("destinos",array("planetas"=>$var,"palabras"=>$palabras),"Destinos disponibles");
        }

        //Acción para ver los vuelos correspondientes al destino
        public function accioninfoDestino(){

            switch($_COOKIE["lang"]){

                case("en"): $palabras = ["en","Wheater: ","Travel time: "," hours","Filter","Company","Boarding date: ","Boarding hour: "];
                            $errPalabras =["Can't find the destiny you are looking for"];
                            break;
                
                default: $palabras = ["es","Clima: ","Duración del viaje: "," horas","Filtrar","Compañía","Fecha de embarque: ","Hora de embarque: "];
                        $errPalabras =["No se ha encontrado el destino que estaba buscando"];
                        break;
              }

            $planeta = new Planetas();

            //Control de vuelos a patir de un código de destino
            if(isset($_GET["codigo"])){
                
                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                
                if (!$planeta->buscarPorId($codigo)){
                    Sistema::app()->paginaError(404,$errPalabras[0]);
                    return;
                }
                else{

                    $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                    $opciones["destino"] = $planeta->nombre;

                    $pagina = isset($_GET["pag"])? CGeneral::addSlashes($_GET["pag"]) : 1;
                    
                    $linf = ($pagina-1)*8;
                    $lsup = $pagina*8;

                    $opciones["limite"] = "$linf,$lsup";

                    //Control del formulario para filtrar los resultados
                    if ($_POST){

                        if (!empty($_POST["compannia"]))
                            $opciones["compannia"] = CGeneral::addSlashes($_POST["compannia"]);
        
                        if (!empty($_POST["fecha"]))
                            $opciones["fecha"] = CGeneral::fechaMysqlANormal($_POST["fecha"]);

                        $dato = CGeneral::peticionCurl($url,"GET",$opciones);
                        $dato = json_decode($dato,true);
        
                        $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$dato,"palabras"=>$palabras),$planeta->nombre);
                        return;
                    }

                    $datos = CGeneral::peticionCurl($url,"GET",$opciones);
                    $datos = json_decode($datos,true);

                    $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$datos,"palabras"=>$palabras),$planeta->nombre);
                    return;
                }
            }
	}
}