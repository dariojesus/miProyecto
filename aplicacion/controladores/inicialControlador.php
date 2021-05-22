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
                        $palabras = ["en","Go ahead and buy one, there are a few remains","Find your next destination"]; 
                        break;

                    default: 
                        $palabras = ["es","Corre que vuelan, quedan pocas plazas","Encuentra tu próximo destino"];
                        break;
                }
            

            //Redirección en el caso de que se haya buscado un planeta
            if (isset($_POST["buscar"])){
                $array = Planetas::devuelvePlanetas(null,$palabras[0]);
                $array = $array[$_POST["buscar"]];
                Sistema::app()->irAPagina(array("inicial","infoDestino?codigo=".$array));
                return;
            }

            $this->dibujaVista("index",array("palabras"=>$palabras),"Indice de la aplicación");
		}

        //Acción para mostrar los planetas (destinos)
        public function accionDestinos(){

            $var = new Planetas();

            switch($_COOKIE["lang"]){

                case("en"): $palabras = ["en","Trip duration: "," hours"];
                            $nombre = "nombre_en";
                            break;

                default: $palabras = ["es","Duración del viaje: "," horas"];
                            $nombre = "nombre";
                            break;
              }

            $sentencia = "SELECT cod_destino, $nombre, duracion_viaje, foto FROM destinos";
            $var = $var->ejecutarSentencia($sentencia);

            $this->dibujaVista("destinos",array("planetas"=>$var,"palabras"=>$palabras),"Destinos disponibles");
        }

        //Acción para ver los vuelos correspondientes al destino
        public function accioninfoDestino(){

            switch($_COOKIE["lang"]){

                case("en"): $palabras = ["en","Wheater: ","Travel time: "," hours","Filter","Company","Boarding date","Boarding hour","Arrival date", "Arrival hour"];
                            $errPalabras =["Can't find the destiny you are looking for"];
                            $campos = ["nombre_en","descripcion_en","clima_en"];
                            break;
                
                default: $palabras = ["es","Clima: ","Duración del viaje: "," horas","Filtrar","Compañía","Fecha de salida","Hora de salida","Fecha de llegada","Hora de llegada"];
                         $errPalabras =["No se ha encontrado el destino que estaba buscando"];
                         $campos = ["nombre","descripcion","clima"];
                         break;
              }

            $planeta = new Planetas();

            //Control de vuelos a patir de un código de destino
            if(isset($_GET["codigo"])){
                
                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $planeta = $planeta->ejecutarSentencia("SELECT cod_destino, 
                                                               {$campos[0]},  
                                                               {$campos[1]}, 
                                                               {$campos[2]},
                                                               duracion_viaje,
                                                               foto,
                                                               nombre
                                                               FROM destinos WHERE cod_destino = '$codigo'");

                if (!$planeta){
                    Sistema::app()->paginaError(404,$errPalabras[0]);
                    return;
                }
                else{
                    $planeta = array_values($planeta[0]);
                    $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                    $opciones["destino"] = array_key_exists(6,$planeta)? $planeta[6]:$planeta[1];
                    

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

                        if (!empty($_POST["fecha_llegada"]))
                            $opciones["fecha_llegada"] = CGeneral::fechaMysqlANormal($_POST["fecha_llegada"]);

                        $dato = CGeneral::peticionCurl($url,"GET",$opciones);
                        $dato = json_decode($dato,true);
        
                        $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$dato,"palabras"=>$palabras),$planeta[1]);
                        return;
                    }

                    $datos = CGeneral::peticionCurl($url,"GET",$opciones);
                    $datos = json_decode($datos,true);

                    $this->dibujaVista("informacionDestino",array("planeta"=>$planeta,"vuelos"=>$datos,"palabras"=>$palabras),$planeta[1]);
                    return;
                }
            }
	}
}