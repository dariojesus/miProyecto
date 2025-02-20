<?php
	 
     //Controlador con acciones respectivas a la API
	class apiControlador extends CControlador{

        public function __construct(){}

        /*
        * Métodos para la gestion del CRUD de vuelos
        *
        */
        
        //Acción que devuelde los vuelos deseados (filtros)
        public function accionVuelosDisponibles(){

            if ($_SERVER["REQUEST_METHOD"]=="GET"){

                $vuelos = new Vuelos();
                $opciones["where"] = "true";
                $opciones["order"] = "plazas";

                //Filtramos por codigo de vuelo
                if (isset($_GET["codigo"])){
                    $dato = CGeneral::addSlashes($_GET["codigo"]);
                    $opciones["where"].=" and cod_vuelo ='$dato'";
                }

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

                if (isset($_GET["disponibles"])){
                    $hoy = new DateTime();
                    $hoy = $hoy->format("Y-m-d");
                    $opciones["where"].= " and fecha_salida >= '$hoy'";
                }

                //Filtramos por fecha de llegada
                if (isset($_GET["fecha_llegada"])){
                    $dato = CGeneral::addSlashes($_GET["fecha_llegada"]);

                    if (!CValidaciones::validaFecha($dato)){
                        echo json_encode(array("Error"=>"La fecha no esta en formato correcto compruebe dd/mm/yyyy"));
                        return;
                    }
                        
                    else{
                        $dato = CGeneral::fechaNormalAMysql($dato);
                        $opciones["where"].= " and fecha_llegada ='$dato'";
                    }
                }

                //Filtramos con un limite de resultados
                if (isset($_GET["limite"])){
                    $limite = CGeneral::addSlashes($_GET["limite"]);
                    $opciones["limit"] = "$limite";
                }


                //En el caso de que se requieran los datos completos del vuelo con su destino
                if (isset($_GET["fullData"])){

                    $sent = "SELECT * FROM vuelos_destinos WHERE {$opciones['where']} ORDER BY {$opciones['order']} LIMIT {$opciones['limit']}";
                    
                    $sent = Sistema::app()->BD()->crearConsulta($sent)->filas();
                    
                    
                    $sent = json_encode($sent);
                    echo $sent;
                }

                //En el caso de que solo se necesiten los datos del vuelo sin destino
                else{
                    $vuelos = $vuelos->buscarTodos($opciones);

                    $vuelos = json_encode($vuelos);
                    echo $vuelos;
                }
            }
        }

        //Acción para crear un vuelo
        public function accionVuelosAgregar(){
            if ($_SERVER["REQUEST_METHOD"]=="POST"){
                $vuelos = new Vuelos();
                
                $vuelos->setValores($_POST);

                //Si no son válidos los datos se devuelven los errores
                if (!$vuelos->validar()){
                    echo json_encode($vuelos->getErrores());
                    return;
                }
                
                //Si son válidos se guarda el objeto y se devuelve correcto
                else{
                    $vuelos->guardar();
                    echo json_encode(array("Ok"=>"Vuelo agregado correctamente."));
                    return;
                }
            }
        }

        //Acción que modifica el vuelo con el cod_vuelo pasado
        public function accionVuelosModificar(){

            if ($_SERVER["REQUEST_METHOD"]=="POST"){
                $vuelos = new Vuelos();

                //Si no se ha pasado el código
                if (!isset($_POST["cod_vuelo"])){
                    echo json_encode(array("Error"=>"No se ha proporcionado un código de vuelo a buscar."));
                    return;
                }

                $codigo=CGeneral::addSlashes($_POST["cod_vuelo"]);
                
                //Se busca el vuelo con el código
                if ($vuelos->buscarPorId($codigo)){

                    $vuelos->setValores($_POST);

                    //Si no son los datos válidos se devuelven sus errores
                    if (!$vuelos->validar()){
                        echo json_encode($vuelos->getErrores());
                        return;
                    }
                        

                    //Si son válidos se guarda el objeto y se devuelve correcto
                    else{
                        $vuelos->guardar();
                        echo json_encode(array("Ok"=>"Vuelo modificado correctamente."));
                        return;
                    }
                }

                //Si no se encuentra el vuelo con dicho código
                else{
                    echo json_encode(array("Error"=>"No se ha encontrado el vuelo especificado."));
                    return;
                }
            }
        }

        //Acción que borra el vuelo con el cod_vuelo pasado
        public function accionVuelosBorrar(){

            if ($_SERVER["REQUEST_METHOD"]=="POST"){
                $vuelos = new Vuelos();

                //Si no se ha pasado el código
                if (!isset($_POST["codigo"])){
                    echo json_encode(array("Error"=>"No se ha proporcionado un código de vuelo a borrar."));
                    return;
                }

                $codigo=CGeneral::addSlashes($_POST["codigo"]);

                //Se busca el vuelo con el código
                if ($vuelos->buscarPorId($codigo)){
                    
                    if ($vuelos->ejecutarSentencia("UPDATE vuelos SET `borrado`='1' WHERE `cod_vuelo`='$codigo'")){
                        echo json_encode(array("Ok"=>"Vuelo eliminado correctamente."));
                        return;
                    }
                    else{
                        echo json_encode(array("Error"=>"No se ha podido llevar acabo la operación de eliminación."));
                        return;
                    }

                }

                //Si no se encuentra el vuelo con dicho código
                else{
                    echo json_encode(array("Error"=>"No se ha encontrado el vuelo especificado."));
                    return;
                }

            }
        }


        /*
        * Métodos útiles para los JS de la página
        *
        */

        //Acción que devuelve los datos de clase dado el código
        public function accionClaseDatos(){

            if ($_SERVER["REQUEST_METHOD"]=="GET"){

                $clase = new Clases();
                $opciones["where"] = "true";

                //Filtramos por codigo de clase
                if (isset($_GET["codigo"])){
                    $dato = CGeneral::addSlashes($_GET["codigo"]);
                    $opciones["where"].=" and `cod_clase` ='$dato'";
                }

                $clase = $clase->buscarTodos($opciones);

                $clase = json_encode($clase);
                echo $clase;
            }

        }

        //Acción que devuelve una lista con los planetas y su codigo
        public function accionPlanetasLista(){

            if ($_SERVER["REQUEST_METHOD"]=="GET"){

                if(isset($_GET["idioma"]))
                    $idioma = CGeneral::addSlashes($_GET["idioma"]);
                    
                $lista = Planetas::devuelvePlanetas(null,$idioma);

                $lista = json_encode($lista);
                echo $lista;
            }
        }
	}