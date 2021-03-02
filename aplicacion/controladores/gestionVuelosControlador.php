<?php

    class gestionVuelosControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="crudVuelos";
        }

        //Acción para mostrar los vuelos en forma de tabla (CRUD)
        public function accionCrudVuelos(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }

            $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
            $datos = CGeneral::peticionCurl($url,"GET",array());

            $datos = json_decode($datos);
            $array = [];

            for ($i = 0; $i < count($datos); $i++) {
                $aux=get_object_vars($datos[$i]);
                $aux["fecha_salida"]=CGeneral::fechaMysqlANormal($aux["fecha_salida"]);
                $aux["cod_destino"]=Planetas::devuelvePlanetas($aux["cod_destino"]);
                $aux["borrado"]=$aux["borrado"]=="1"?"Si":"No";
                $array[]=$aux;
            }

            echo $this->dibujaVistaParcial("crudVuelos",array("vuelos"=>$array),true);
        }

        //Acción para agregar un nuevo vuelo
        public function accionAgregar(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }

            $vuelo = new Vuelos();
            $datos = $vuelo->getNombre();
            $destinos = array_flip(Planetas::devuelvePlanetas());

            if ($_POST){

                $datos = $_POST[$datos];
                $datos["hora_salida"] .= ":00";

                $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosAgregar"]);
                $datos = CGeneral::peticionCurl($url,"POST",$datos);

                $datos = json_decode($datos,true);

                if (isset($datos["Ok"])){
                    Sistema::app()->irAPagina(array("gestionVuelos","Correcta"));
                    return;
                }

                else{
                    echo $this->dibujaVistaParcial("agregarVuelo",array("modelo"=>$vuelo,"destinos"=>$destinos,"errores"=>$datos),true).PHP_EOL;
                    return;
                }
            }

            echo $this->dibujaVistaParcial("agregarVuelo",array("modelo"=>$vuelo,"destinos"=>$destinos),true).PHP_EOL;

        }

        //Acción para mostrar los datos de un solo vuelo
        public function accionMostrar(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }

            if ($_GET["codigo"]){

                $vuelo = new Vuelos();
                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                $datos = CGeneral::peticionCurl($url,"GET",array("codigo"=>$codigo));

                $datos = json_decode($datos);
                $datos = get_object_vars($datos[0]);
                $vuelo->setValores($datos);

                echo $this->dibujaVistaParcial("mostrarVuelo",array("modelo"=>$vuelo),true);

            }
        }

        //Acción para modificar los datos de un vuelo
        public function accionModificar(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(2)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }

            $vuelo = new Vuelos();
            $miURL = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["gestionVuelos","Modificar"]);
            
            //Primero se muestran los datos del vuelo
            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
                $datos = CGeneral::peticionCurl($url,"GET",array("codigo"=>$codigo));

                $datos = json_decode($datos);
                $datos = get_object_vars($datos[0]);
                $vuelo->setValores($datos);

                echo $this->dibujaVistaParcial("modificarVuelo",array("modelo"=>$vuelo,"formulario"=>$miURL),true);
            }

            //Entrará cuando se haya pulsado el botón modificar del formulario anterior
            else if ($_POST){
            
                $_POST[$vuelo->getNombre()]["hora_salida"] .= ":00";

                $datos = $_POST[$vuelo->getNombre()];
                $vuelo->setValores($datos);

                $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosModificar"]);
                $datos = CGeneral::peticionCurl($url,"POST",$datos);

                $datos = json_decode($datos, true);

                if (isset($datos["Ok"])){
                    Sistema::app()->irAPagina(array("gestionVuelos","Correcta"));
                    return;
                }

                echo $this->dibujaVistaParcial("modificarVuelo",array("modelo"=>$vuelo,"formulario"=>$miURL,"errores"=>$datos),true);
            }
        }

        //Acción para eliminar los datos de un vuelo
        public function accionBorrar(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(3)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }

            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);

                $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosBorrar"]);
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
            echo $this->dibujaVistaParcial("correcto",array("mensaje"=>"Acción realizada correctamente, puede cerrar esta pestaña."),true).PHP_EOL;
            return;
        }
    }

?>