<?php
	 
     //Controlador con acciones respectivas a la API
	class apiControlador extends CControlador{

        public function __construct(){}
        
        public function accionVuelosDisponibles(){

            if ($_SERVER["REQUEST_METHOD"]=="GET"){

                $vuelos = new Vuelos();
                $opciones["where"] = "true";

                //Filtramos por destino
                if (isset($_GET["destino"])){

                    $var = Planetas::devuelvePlanetas();
                    $dato = CGeneral::addSlashes($_GET["destino"]);

                    if (!array_key_exists($dato,$var)){
                        echo json_encode(array("Error"=>"No existen vuelos al planeta elegido"),JSON_PRETTY_PRINT);
                        return;
                    }
                    else
                        $opciones["where"].=" and cod_destino ='$var[$dato]'";
                }

                //Filtramos por borrado
                if (isset($_GET["borrado"])){
                    $dato = CGeneral::addSlashes($_GET["borrado"]);
                    $opciones["where"].= " and borrado ='$dato'";
                }
                else
                    $opciones["where"].= " and borrado ='0'";
                
                //Filtramos por compannia de vuelo
                if (isset($_GET["compannia"])){
                    $dato = CGeneral::addSlashes($_GET["compannia"]);
                    $opciones["where"].= " and compannia ='$dato'";
                }

                //Filtramos por fecha de salida
                if (isset($_GET["fecha"])){
                    $dato = CGeneral::addSlashes($_GET["fecha"]);

                    if (!CValidaciones::validaFecha($dato)){
                        echo json_encode(array("Error"=>"La fecha no esta en formato correcto compruebe dd/mm/yyyy"));
                        return;
                    }
                        
                    else{
                        $dato = CGeneral::fechaNormalAMysql($dato);
                        $opciones["where"].= " and fecha_salida ='$dato'";
                    }
                }

                $vuelos = $vuelos->buscarTodos($opciones);

                $vuelos = json_encode($vuelos);
                echo $vuelos;
            }
    
    }
	}