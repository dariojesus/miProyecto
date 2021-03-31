<?php

    require_once("./librerias/TCPDF-main/tcpdf.php");
    require_once("./librerias/TCPDF-main/tcpdf_barcodes_2d.php");
	 
     //Controlador con acciones respectivas a la compra de billetes
	class compraControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto="compra";
        }

        //Acción para proceder a la compra de un billete
		public function accionCompra(){

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(1)){
                Sistema::app()->paginaError(401,"No tiene permisos para acceder a esta acción.");
            }
            
            //Se muestra primero el billete a comprar con todos sus datos
            if (isset($_GET["codigo"])){

                $vuelo = new Vuelos();
                $usuario = new Registro();
                $url = Sistema::app()->generaURL(["inicial","Destinos"]);

                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $vuelo->buscarPorId($codigo);

                $codigo = CGeneral::addSlashes(Sistema::app()->acceso()->getNif());
                $codigo = Sistema::app()->BD()->crearConsulta("SELECT `cod_usuario` FROM usuarios WHERE `nif`='$codigo'")->fila()["cod_usuario"];
                $usuario->buscarPorId($codigo);

                //Se entra si se ha pulsado en el formulario el boton de comprar
                if ($_POST){
                    if (!empty($_POST["clase"])){

                        $billete = new Billetes();
                        $billete->setValores(
                                    array("cod_clase"=>$_POST["clase"],
                                          "cod_vuelo"=>$vuelo->cod_vuelo,
                                          "cod_perfil"=>$codigo,
                                          "borrado"=>0));

                        if ($billete->validar()){
                            $billete->guardar();

                            //Se le resta la plaza al vuelo
                            $plazas = Sistema::app()->BD()->crearConsulta("SELECT `plazas` FROM vuelos WHERE `cod_vuelo`='{$vuelo->cod_vuelo}'")->fila()["plazas"]; 
                            $plazas = intval($plazas)-1;
                            Sistema::app()->BD()->crearConsulta("UPDATE vuelos SET `plazas`='$plazas' WHERE `cod_vuelo`='{$vuelo->cod_vuelo}'");

                            Sistema::app()->irAPagina(array("logueo","MiCuenta"));
                            return;
                        }
                    }
                }
               

                $this->dibujaVista("compraBillete",array("vuelo"=>$vuelo,"usuario"=>$usuario,"url"=>$url),"Compra de billete");
                return;
            }
            
		}

        //Acción para imprimir un billete comprado de un usuario
        public function accionImprimirBillete(){

            if ($_GET["codigo"]){

                $acceso = Sistema::app()->acceso();

                if ($acceso->hayUsuario()){

                    $acceso = CGeneral::addSlashes($acceso->getNif());
                    $codigo = CGeneral::addSlashes($_GET["codigo"]);

                    $acceso = Sistema::app()->BD()->crearConsulta("SELECT * FROM perfiles_vuelos WHERE `nif`='$acceso' AND `codigo`='$codigo'");

                    if ($acceso = $acceso->fila()){

                        //Se crea el documento
                        $pdf = new TCPDF("L",PDF_UNIT,"A6");

                        //Configuraciones generales del pdf
                        $pdf->SetCreator("TCPDF");
                        $pdf->SetAuthor("Horizons-Darío Jesús Flores Sevilla");
                        $pdf->SetTitle("Ticket-".$acceso["destino"].$acceso["codigo"]);
                        $pdf->SetSubject("Ticket de vuelo");
                        $pdf->SetKeywords("Ticket, Billete, Vuelo, Compra, Viaje");
                        

                        //Congifuración de cabecera
                        $des_cabecera = "by ".Sistema::app()->autor.PHP_EOL.$_SERVER["HTTP_HOST"];
                        $pdf->setHeaderData("64.jpg",15,Sistema::app()->empresa,$des_cabecera);
                        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                        //Ajuste de margenes
                        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
                        $pdf->SetMargins(7,PDF_MARGIN_TOP,7);
                        $pdf->SetAutoPageBreak(true,15);
                        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                        

                        //Ajuste del tipo de letra
                        $pdf->SetFont("helvetica","",10);

                        //Se añade la página
                        $pdf->AddPage();

                        //Se crea el código QR
                        $qr_code = new TCPDF2DBarcode("www.horizons.com","QRCODE,H");

                        //Se escribe el contenido del pdf
                        $html = <<<EOF
                        <style>
                            th{
                                font-weight: bold;
                                }
                        </style>

                        <div>
                            <table cellpadding="1" cellspacing="3">
                                <tr>
                                    <th>Pasajero: </th>
                                    <th>Destino: </th>
                                    <td rowspan="8">Código QR</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso["nombre_completo"]}</td>
                                    <td>&nbsp;{$acceso["destino"]}</td>
                                </tr>
                                <tr>
                                    <th>Identificacion: </th>
                                    <th>Fecha de salida: </th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso["nif"]}</td>
                                    <td>&nbsp;{$acceso["fecha_salida"]}</td>
                                </tr>
                                <tr>
                                    <th>Clase: </th>
                                    <th>Hora de salida: </th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso["clase"]}</td>
                                    <td>&nbsp;{$acceso["hora_salida"]}</td>
                                </tr>
                                <tr>
                                    <th>Compañia: </th>
                                    <th>Duración del viaje: </th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso["compannia"]}</td>
                                    <td>&nbsp;{$acceso["duracion_viaje"]} horas</td>
                                </tr>
                            </table>
                        </div>
                        EOF;

                        $pdf->writeHTML($html,true,false,true,false,"");
                        $pdf->lastPage();
                        $pdf->Output("Ticket-".$acceso["destino"].$acceso["codigo"].".pdf","I");
                    }


                }
                else{
                    Sistema::app()->irAPagina(array("logueo","Formulario"));
                    return;
                }

            }
        }

        //Acción para anular un billete de un usuario
        public function accionAnular(){

            $acceso = Sistema::app()->acceso();

            //Si no hay usuario
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no viene el codigo del billete en el GET
            if (!isset($_GET["codigo"])){
                Sistema::app()->paginaError(404,"No existe la página que está buscando");
                return;
            }

            $bd = Sistema::app()->BD();
            $cod = CGeneral::addSlashes($_GET["codigo"]);
            $var = $acceso->getNif();

            $var = $bd->crearConsulta("SELECT `fecha_salida`,`hora_salida` FROM perfiles_vuelos WHERE `borrado`='0' AND `codigo`='$cod' AND `nif`='$var'");

            //Si el billete ya está borrado o no corresponde con el nif del cliente que lo desea borrar
            if ($var->numFilas()==0){
                Sistema::app()->paginaError(500,"No se puede realizar la acción que desea");
                return;
            }

            //Se comprueba si faltan mas de 24 horas para la salida del vuelo
            $hoy = new DateTime();

            $salida = $var->fila();
            $salida = $salida["fecha_salida"]." ".$salida["hora_salida"];
            $salida = new DateTime($salida);

            $diferencia = $hoy->diff($salida);

            //Si faltan menos de 24 horas se produce un error
            if ($diferencia->days < 1 || $diferencia->invert == 1){
                Sistema::app()->paginaError(500,"No se puede anular un billete a menos de 24 horas de su salida");
                return;
            }

            //Todo ha ido bien, se procede a borrar el billete del usuario
            $bd->crearConsulta("UPDATE billetes SET `borrado`='1' WHERE `cod_billete`='$cod'");
            $var = $bd->crearConsulta("SELECT `cod_vuelo` FROM billetes WHERE `cod_billete`='$cod'")->fila()["cod_vuelo"];

            //Se restaura la plaza de vuelo
            $plz = $bd->crearConsulta("SELECT `plazas` FROM vuelos WHERE `cod_vuelo`='$var'")->fila()["plazas"];
            $plz++;
            $bd->crearConsulta("UPDATE vuelos SET `plazas`='$plz' WHERE `cod_vuelo`='$var'");

            //Se vuelve a la página de mis viajes proximos
            Sistema::app()->irAPagina(array("logueo","Viajes?op=1"));
            return;
        }

}