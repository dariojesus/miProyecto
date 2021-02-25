<?php

    class gestionVuelosControlador extends CControlador{

        public function __construct()
        {
            $this->accionDefecto ="crudVuelos";
        }

        //Acción para mostrar los vuelos en forma de tabla (CRUD)
        public function accionCrudVuelos(){

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

        //Acción para mostrar los datos de un solo vuelo
        public function accionMostrar(){

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

        public function accionModificar(){

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

            $datos = json_decode($datos);

            echo $this->dibujaVistaParcial("modificarVuelo",array("modelo"=>$vuelo,"formulario"=>$miURL,"errores"=>$datos),true);
            }
        }

    }

?>