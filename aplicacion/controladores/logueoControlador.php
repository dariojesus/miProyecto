<?php
     //Controlador con acciones respectivas a la cuenta
	class logueoControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="formulario";
        }

        //Acción para acceder al login
		public function accionFormulario(){

            $acceso = Sistema::app()->acceso();

            //Si ya estas logeado no puedes volver a logearte
            if ($acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("inicial","Principal"));
                return;
            }

            //Sino accedes al login
            $login = new Login();
            $datos = $login->getNombre();

            if (isset($_POST[$datos])){

                $login->setValores($_POST[$datos]);

                if ($login->validar()){
                    Sistema::app()->irAPagina(array("inicial","Principal"));
                    return;
                }
            }

            echo $this->dibujaVistaParcial("index",array("modelo"=>$login),true).PHP_EOL;
		}

        //Accion para acceder al formulario de registro
        public function accionRegistro(){

            $acceso = Sistema::app()->acceso();

            //Si ya estas logueado no puedes registrarte
            if ($acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("inicial","Principal"));
                return;
            }

            //Si no, accedes al formulario de registro
            $registro = new Registro();
            $datos = $registro->getNombre();
            $exito = "";

            if (isset($_POST[$datos]) && isset($_POST["contrasenna"])){

                $registro->setValores($_POST[$datos]);
                $exito = CGeneral::passwordSegura($_POST["contrasenna"],50);

                //Si los datos son validos y la contraseña cumple los requisitos, se guarda en usuarios y en perfiles
                if ($registro->validar() &&  $exito === true){

                    if ($registro->guardar()){
                        $acl = Sistema::app()->ACL();
                        $contra = $_POST["contrasenna"];

                        $acl->anadirUsuario($registro->nif, $contra, 1);
                        Sistema::app()->irAPagina(array("logueo","Formulario"));
                        return;
                    }
                }
            }

            echo $this->dibujaVistaParcial("registro",array("modelo"=>$registro,"error"=>$exito),true).PHP_EOL;
        }

        //Acción para recuperar la contraseña del usuario dado el email
        public function accionOlvido(){

            //Si se ha enviado el formulario de recuperación de contra
            if (isset($_POST["correo"])){

                $correo = CGeneral::addSlashes($_POST["correo"]);
                $nif = CGeneral::addSlashes($_POST["nif"]);
                $usr = new Registro();

                //Si el correo se encuentra en la base de datos de nuestros usuarios
                if ($usr->buscarPor(array("where"=>"email = '$correo' and nif = '$nif'"))){

                    $contra = Login::emailRecuperacion($correo);

                    if (is_string($contra)){
                        $_SESSION["aleatoria"] = $contra;
                        $_SESSION["id"] = $nif;
                        Sistema::app()->irAPagina(array("logueo","ConfirmarRecepcion"));
                    }
                    else
                        Sistema::app()->PaginaError("504","No se ha podido enviar el correo de recuperación, disculpe las molestias");

                    return;
                }

            }

            echo $this->dibujaVistaParcial("olvido",[],true);
            return;
        }

        //Acción para confirmar la recepción del correo de recuperación
        public function accionConfirmarRecepcion(){

            if ($_POST){

                $acl = Sistema::app()->ACL();

                $cod = $acl->getCodUsuario($_SESSION["id"]);
                $acl->setContrasenia($cod, $_SESSION["aleatoria"]);
    
                unset($_SESSION["id"]);
                unset($_SESSION["aleatoria"]);

                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            echo $this->dibujaVistaParcial("confirmarRecepcion",[],true);
            return;
        }

        //Accion para acceder a mi cuenta
        public function accionMiCuenta(){
            $acceso = Sistema::app()->acceso();

            //Si estas logueado accedes a tu cuenta, sino no tienes permiso
            if ($acceso->hayUsuario()){

                $var = $acceso->getNif();
                $var = Sistema::app()->BD()->crearConsulta("SELECT `nombre`, `apellidos` FROM perfiles WHERE `nif`='$var'")->fila();
                $var = $var["nombre"]." ".$var["apellidos"];

                $opciones = array(
                    "datos"=> Sistema::app()->generaURL(array("logueo","MisDatos")),
                    "proximos"=> Sistema::app()->generaURL(array("logueo","Viajes"))."?op=1",
                    "anteriores" => Sistema::app()->generaURL(array("logueo","Viajes"))."?op=2"
                );

                $this->dibujaVista("cuenta",array("nombre"=>$var,"op"=>$opciones),"Mi cuenta");
            }
                
            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));
        }

        //Acción para consultar los datos del usuario logueado
        public function accionMisDatos(){

            $acceso = Sistema::app()->acceso();
            $acl = Sistema::app()->ACL();

            //Si estas logueado accedes a tus datos, sino no tienes permiso
            if ($acceso->hayUsuario()){

                $usr = new Registro();
                $nif = CGeneral::addSlashes($acceso->getNif());

                $usr->buscarPor(array("where"=>"`nif` ='$nif'"));
                
                //Se ha pulsado el formulario para modificar los datos
                if ($_POST){
                    $usr->setValores($_POST[$usr->getNombre()]);

                    //Si los datos personales son validos se guardan
                    if ($usr->validar()){
                        $usr->guardar();
                        
                        //Si se quiere cambiar la contraseña y la antigua es correcta
                        if (!empty($_POST["newPass"]) && $acl->esValido($nif,$_POST["oldPass"]))
                            $acl->setContrasenia($acl->getCodUsuario($nif), $_POST["newPass"]);
                    }
                        
                }

                $rol = $acl->getUsuarioRole($acl->getCodUsuario($nif));
                $usr->fecha_nacimiento = CGeneral::fechaNormalAMysql($usr->fecha_nacimiento);
                $this->dibujaVista("cuenta_datos",["modelo"=>$usr,"rol"=>$rol],"Datos de cuenta");
            }

            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));
        }

        //Acción para que el usuario consulte sus viajes pasados/proximos (segun op GET)
        public function accionViajes(){
            $acceso = Sistema::app()->acceso();

            if ($acceso->hayUsuario()){

                if (!isset($_GET["op"])){
                    Sistema::app()->paginaError("404","La página web solicitada no ha sido encontrada.");
                    return;
                }

                if ($_GET["op"]!="1" && $_GET["op"]!="2"){
                    Sistema::app()->paginaError("404","La página web solicitada no ha sido encontrada.");
                    return;
                }
                
                //Si es 1, son los viajes posteriores a la fecha, sino son los anteriores a la fecha
                $operando = $_GET["op"]=="1"?">=":"<";

                $var = CGeneral::addSlashes($acceso->getNif());
                $fec_actual = date("Y-m-d");

                $var = Sistema::app()->BD()->crearConsulta("SELECT * FROM perfiles_vuelos WHERE `nif`='$var' AND `borrado`='0' AND `fecha_salida` $operando '$fec_actual'")->filas();
                $url = Sistema::app()->generaURL(array("compra","ImprimirBillete"));

                $this->dibujaVista("proximosViajes",array("billetes"=>$var,"url"=>$url, "op"=>$_GET["op"]),"Billetes");

            }
            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));   
        }

        //Accion para logout
        public function accionQuitarRegistro(){
            $acceso = Sistema::app()->acceso();
            $acceso->quitarRegistroUsuario();
            Sistema::app()->irAPagina(array("inicial","Principal"));
        }
		
	}