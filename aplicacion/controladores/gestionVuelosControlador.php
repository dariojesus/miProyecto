<?php

    class gestionVuelosControlador extends CControlador{

        public function __construct()
        {
            $this->accionDefecto ="crudVuelos";
        }

        public function accionCrudVuelos(){

            $url = $_SERVER["HTTP_HOST"].Sistema::app()->generaURL(["api","VuelosDisponibles"]);
            $datos = CGeneral::peticionCurl($url,"GET",array());

            $datos = json_decode($datos);
            $array = [];

            for ($i = 0; $i < count($datos); $i++) {
                $aux=get_object_vars($datos[$i]);
                $aux["fecha_salida"]=CGeneral::fechaMysqlANormal($aux["fecha_salida"]);
                $aux["cod_destino"]=Planetas::devuelvePlanetas($aux["cod_destino"]);
                $array[]=$aux;
            }

            echo $this->dibujaVistaParcial("crudVuelos",array("vuelos"=>$array),true);
        }

    }

?>