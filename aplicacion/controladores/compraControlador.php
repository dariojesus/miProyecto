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

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["en","Boarding data","Company","Destiny","Boarding date","Boarding hour",
                                "Passenger data","ID","Name","Subname","Email",
                                "Billing","Class","Price","Next",
                                "Buy","Cancel","Buying process"];
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["es","Datos de embarque","Compañia","Destino","Fecha de embarque","Hora de embarque",
                                "Datos del pasajero","NIF","Nombre","Apellidos","Email",
                                "Facturación","Clase","Precio","Siguiente",
                                "Comprar","Cancelar","Proceso de compra"];
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
            if (!$acceso->puedePermisos(1)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
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

                            Sistema::app()->irAPagina(array("compra","Correcta"));
                            return;
                        }
                    }
                }
               
                $destino = Planetas::devuelvePlanetas($vuelo->__get("cod_destino"),$palabras[0]);
                $this->dibujaVista("compraBillete",array("vuelo"=>$vuelo,"usuario"=>$usuario,"url"=>$url,"palabras"=>$palabras,"dest"=>$destino),$palabras[17]);
                return;
            }
            
		}

        //Acción para imprimir un billete comprado de un usuario
        public function accionImprimirBillete(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Fly ticket","Passenger: ","Destiny: ","Identification: ","Boarding date: "
                                ,"Class: ","Boarding hour: ","Company: ", "Fly duration: "," hours"];
                    $campos = ["clase_en","destino_en"];
                    break;

                default: 
                    $palabras = ["Ticket de vuelo","Pasajero: ","Destino: ","Identificación: ","Fecha de embarque: "
                                ,"Clase: ","Hora de embarque: ","Compañia: ","Duración del vuelo: "," horas"];
                    $campos = ["clase","destino"];
                    break;
            }

            if ($_GET["codigo"]){

                $acceso = Sistema::app()->acceso();

                if ($acceso->hayUsuario()){

                    $acceso = CGeneral::addSlashes($acceso->getNif());
                    $codigo = CGeneral::addSlashes($_GET["codigo"]);

                    $acceso = Sistema::app()->BD()->crearConsulta("SELECT nif,
                                                                          nombre_completo,
                                                                          codigo,
                                                                          fecha_salida,
                                                                          hora_salida,
                                                                          compannia,
                                                                          {$campos[0]},
                                                                          precio,
                                                                          {$campos[1]},
                                                                          duracion_viaje
                                                                    FROM perfiles_vuelos 
                                                                    WHERE `nif`='$acceso' 
                                                                    AND `codigo`='$codigo'");

                    if ($acceso = $acceso->fila()){

                        $acceso = array_values($acceso);

                        //Se crea el documento
                        $pdf = new TCPDF("L",PDF_UNIT,"A6");

                        //Configuraciones generales del pdf
                        $pdf->SetCreator("TCPDF");
                        $pdf->SetAuthor("Horizons-Darío Jesús Flores Sevilla");
                        $pdf->SetTitle("Ticket-".$acceso[8].$acceso[2]);
                        $pdf->SetSubject($palabras[0]);
                        $pdf->SetKeywords("Ticket, Billete, Vuelo, Compra, Viaje");
                        

                        //Congifuración de cabecera
                        $des_cabecera = "by ".Sistema::app()->autor.PHP_EOL.$_SERVER["HTTP_HOST"];
                        $pdf->setHeaderData("64.jpg",15,Sistema::app()->empresa,$des_cabecera);
                        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

                        //Ajuste de margenes
                        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
                        $pdf->SetMargins(7,PDF_MARGIN_TOP,7);
                        $pdf->SetAutoPageBreak(false);
                        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                        //Ajuste del tipo de letra
                        $pdf->SetFont("helvetica","",10);

                        //Se añade la página
                        $pdf->AddPage();

                        //Se crea el código QR y su estilo
                        
                        $style = array(
                            'border' => false,
                            'padding' => 0,
                            'fgcolor' => array(4, 57, 78),
                            'bgcolor' => false
                        );

                        $datos = $palabras[1].":".$acceso[1]."-".$acceso[0]."|".$palabras[2].":".$acceso[8]."-".$acceso[5]."-".$acceso[3];
                        $codigo_qr = $pdf->serializeTCPDFtagParameters(array($datos, 'QRCODE,H', 90, 25, 50, 50, $style, 'N'));
                        
                        
                        //Se escribe el contenido del pdf
                        $html = <<<EOF
                        <style>
                            th{
                                font-weight: bold;
                                }
                        </style>

                        <div>
                            <table cellpadding="1" cellspacing="2">
                                <tr>
                                    <th>$palabras[1]</th>
                                    <th>$palabras[2]</th>
                                    <td rowspan="8"><tcpdf method="write2DBarcode" params="$codigo_qr" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso[1]}</td>
                                    <td>&nbsp;{$acceso[8]}</td>
                                </tr>
                                <tr>
                                    <th>$palabras[3]</th>
                                    <th>$palabras[4]</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso[0]}</td>
                                    <td>&nbsp;{$acceso[3]}</td>
                                </tr>
                                <tr>
                                    <th>$palabras[5]</th>
                                    <th>$palabras[6]</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso[6]}</td>
                                    <td>&nbsp;{$acceso[4]}</td>
                                </tr>
                                <tr>
                                    <th>$palabras[7]</th>
                                    <th>$palabras[8]</th>
                                </tr>
                                <tr>
                                    <td>&nbsp;{$acceso[5]}</td>
                                    <td>&nbsp;{$acceso[9]}$palabras[9]</td>
                                </tr>
                            </table>
                        </div>
                        EOF;

                        $pdf->writeHTML($html,true,false,true,false,"");
                        $pdf->lastPage();
                        $pdf->Output("Ticket-".$acceso[8].$acceso[2].".pdf","I");
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

            switch($_COOKIE["lang"]){
                case("en"): 
                    $errPalabras = ["The page you are looking for doesn't exist","The action can't be performed",
                                    "The ticket can't be canceled when the boarding date is less than 24 hours"];
                    break;

                default: 
                    $errPalabras = ["No existe la página que está buscando","No se puede realizar la acción que desea",
                                    "No se puede anular un billete a menos de 24 horas de su salida"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no hay usuario
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no viene el codigo del billete en el GET
            if (!isset($_GET["codigo"])){
                Sistema::app()->paginaError(404,$errPalabras[0]);
                return;
            }

            $bd = Sistema::app()->BD();
            $cod = CGeneral::addSlashes($_GET["codigo"]);
            $var = $acceso->getNif();

            $var = $bd->crearConsulta("SELECT `fecha_salida`,`hora_salida` FROM perfiles_vuelos WHERE `borrado`='0' AND `codigo`='$cod' AND `nif`='$var'");

            //Si el billete ya está borrado o no corresponde con el nif del cliente que lo desea borrar
            if ($var->numFilas()==0){
                Sistema::app()->paginaError(500,$errPalabras[1]);
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
                Sistema::app()->paginaError(500,$errPalabras[2]);
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

        //Acción para confirmar la compra del billete
        public function accionCorrecta(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $mensaje = "Your purchase have been made correctly, you can check your tickets on next trips section.";
                    $txtBoton = "Continue";
                    break;

                default: 
                    $mensaje = "Su compra se ha relizado correctamente, puede consultar sus billetes en su sección de próximos viajes.";
                    $txtBoton = "Continuar";
                    break;
            }


            echo $this->dibujaVistaParcial("correcto",array("mensaje"=>$mensaje,"txt"=>$txtBoton),true).PHP_EOL;
            return;
        }

}