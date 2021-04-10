<?php

    class gestionVuelosControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="crudVuelos";
        }

        //Acción para mostrar los vuelos en forma de tabla (CRUD)
        public function accionCrudVuelos(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Yes","No","Login","My account","Home","Trips","Trips management","Users management","Logout",
                                 "Departure date","Departure hour","Company","Seats","Destiny","Deleted","Action",
                                 "Delete flight","You are abou to delete the flight with the next data:","Are you sure you want to proceed with the operation?"];
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Si","No","Iniciar sesión","Mi cuenta","Inicio","Viajes","Gestión de viajes","Gestión de usuarios","Logout",
                                 "Fecha de salida","Hora de salida","Compañia","Plazas","Destino","Borrado","Acción",
                                 "Borrar vuelo","Está a punto de borrar el vuelo","¿Está seguro de que desea proceder con la operación?"];
                    $errPalabras = ["No tiene permisos para acceder a esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
            $datos = CGeneral::peticionCurl($url,"GET",array());

            $datos = json_decode($datos);
            $array = [];

            for ($i = 0; $i < count($datos); $i++) {
                $aux=get_object_vars($datos[$i]);
                $aux["fecha_salida"]=CGeneral::fechaMysqlANormal($aux["fecha_salida"]);
                $aux["cod_destino"]=Planetas::devuelvePlanetas($aux["cod_destino"]);
                $aux["borrado"]=$aux["borrado"]=="1"?$palabras[0]:$palabras[1];
                $array[]=$aux;
            }

            echo $this->dibujaVistaParcial("crudVuelos",array("vuelos"=>$array,"palabras"=>$palabras),true);
        }

        //Acción para agregar un nuevo vuelo
        public function accionAgregar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["General data","Company","Departure date","Departure hour","Seats","Destiny","Add"];
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Datos generales","Compañia","Fecha de salida","Hora de salida","Plazas","Destino","Agregar"];
                    $errPalabras = ["No tiene permisos para acceder a esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            $vuelo = new Vuelos();
            $datos = $vuelo->getNombre();
            $destinos = array_flip(Planetas::devuelvePlanetas());

            if ($_POST){

                $datos = $_POST[$datos];
                $datos["hora_salida"] .= ":00";

                $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosAgregar"]);
                $datos = CGeneral::peticionCurl($url,"POST",$datos);

                $datos = json_decode($datos,true);

                if (isset($datos["Ok"])){
                    Sistema::app()->irAPagina(array("gestionVuelos","Correcta"));
                    return;
                }

                else{
                    echo $this->dibujaVistaParcial("agregarVuelo",array("modelo"=>$vuelo,"destinos"=>$destinos,"errores"=>$datos,"palabras"=>$palabras),true).PHP_EOL;
                    return;
                }
            }

            echo $this->dibujaVistaParcial("agregarVuelo",array("modelo"=>$vuelo,"destinos"=>$destinos,"palabras"=>$palabras),true).PHP_EOL;

        }

        //Acción para mostrar los datos de un solo vuelo
        public function accionMostrar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["General data","Company","Departure date","Departure hour","Seats","Destiny code","Administrative data","Deleted"];
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Datos generales","Compañia","Fecha de salida","Hora de salida","Plazas","Destino","Datos administrativos","Borrado"];
                    $errPalabras = ["No tiene permisos para acceder a esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            if ($_GET["codigo"]){

                $vuelo = new Vuelos();
                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                $datos = CGeneral::peticionCurl($url,"GET",array("codigo"=>$codigo));

                $datos = json_decode($datos);
                $datos = get_object_vars($datos[0]);
                $vuelo->setValores($datos);

                echo $this->dibujaVistaParcial("mostrarVuelo",array("modelo"=>$vuelo,"palabras"=>$palabras),true);

            }
        }

        //Acción para modificar los datos de un vuelo
        public function accionModificar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["General data","Company","Departure date","Departure hour","Seats","Destiny code","Administrative data","Deleted","Modify"];
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Datos generales","Compañia","Fecha de salida","Hora de salida","Plazas","Destino","Datos administrativos","Borrado","Modificar"];
                    $errPalabras = ["No tiene permisos para acceder a esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            $vuelo = new Vuelos();
            $miURL = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["gestionVuelos","Modificar"]);
            
            //Primero se muestran los datos del vuelo
            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                $datos = CGeneral::peticionCurl($url,"GET",array("codigo"=>$codigo));

                $datos = json_decode($datos);
                $datos = get_object_vars($datos[0]);
                $vuelo->setValores($datos);

                echo $this->dibujaVistaParcial("modificarVuelo",array("modelo"=>$vuelo,"formulario"=>$miURL,"palabras"=>$palabras),true);
            }

            //Entrará cuando se haya pulsado el botón modificar del formulario anterior
            else if ($_POST){
            
                $_POST[$vuelo->getNombre()]["hora_salida"] .= ":00";

                $datos = $_POST[$vuelo->getNombre()];
                $vuelo->setValores($datos);

                $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosModificar"]);
                $datos = CGeneral::peticionCurl($url,"POST",$datos);

                $datos = json_decode($datos, true);

                if (isset($datos["Ok"])){
                    Sistema::app()->irAPagina(array("gestionVuelos","Correcta"));
                    return;
                }

                echo $this->dibujaVistaParcial("modificarVuelo",array("modelo"=>$vuelo,"formulario"=>$miURL,"errores"=>$datos,"palabras"=>$palabras),true);
            }
        }

        //Acción para eliminar los datos de un vuelo
        public function accionBorrar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $errPalabras = ["No tiene permisos para realizar esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(3)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["SERVER_NAME"].Sistema::app()->generaURL(["api","VuelosBorrar"]);
                $datos = CGeneral::peticionCurl($url,"POST",array("codigo"=>$codigo));
                $datos = get_object_vars(json_decode($datos));

                if (array_key_exists("Ok",$datos)){
                    Sistema::app()->irAPagina(array("gestionVuelos","crudVuelos"));
                    return;
                }

                else{
                    Sistema::app()->paginaError(400,$datos["Error"]);
                    return;
                }
            }
        }

        //Acción para mostrar una animación de que todo ha ido bien
        public function accionCorrecta(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $msg = "Action done sucefully, please close this window to refresh the data.";;
                    break;

                default: 
                    $msg = "Acción realizada correctamente, puede cerrar esta pestaña para actualizar los datos.";
                    break;
            }

            echo $this->dibujaVistaParcial("correcto",array("mensaje"=>$msg),true).PHP_EOL;
            return;
        }
    }

?>