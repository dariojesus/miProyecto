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

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["en","ID","Password","Remember my credentials","Login","Sign up","Forgotten password"]; 
                    break;

                default: 
                    $palabras = ["es","NIF","Contraseña","Recuerda mis credenciales","Acceder","Registrarse","Contraseña olvidada"];
                    break;
            }

            $login = new Login();
            $datos = $login->getNombre();

            if (isset($_POST[$datos])){

                $login->setValores($_POST[$datos]);

                if ($login->validar()){
                    Sistema::app()->irAPagina(array("inicial","Principal"));
                    return;
                }
            }

            echo $this->dibujaVistaParcial("index",array("modelo"=>$login,"palabras"=>$palabras),true).PHP_EOL;
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

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["en","Personal data","ID","Name","Subname","Birth date",
                                     "Contact data","Email","Repeat email","Town","Address",
                                     "Security","Password","Repeat password",
                                     "Sign up"]; 
                    break;

                default: 
                    $palabras = ["es","Datos personales","NIF","Nombre","Apellidos","Fecha de nacimiento",
                                      "Datos de contacto","Email","Repetir email","Población","Dirección",
                                      "Seguridad","Contraseña","Repetir contraseña",
                                      "Registrarse"]; 
                    break;
            }

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

            echo $this->dibujaVistaParcial("registro",array("modelo"=>$registro,"error"=>$exito,"palabras"=>$palabras),true).PHP_EOL;
        }

        //Acción para recuperar la contraseña del usuario dado el email
        public function accionOlvido(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["en","ID","Email","Send email","Cancel","Fill the fields with you ID and email if they match with our records an password recovery mail will be send."];
                    $mensaje = ["This is your new password: "," please don`t share with anyone and change it when you log in."];
                    $errPalabras = ["The email recovery password can't be send, try again later"]; 
                    break;

                default: 
                    $palabras = ["es","DNI","Email","Enviar email","Cancelar","Indícanos tu dni y email, si coincide con nuestros registros recibirás un correo electrónico con la nueva contraseña."];
                    $mensaje = ["Esta es tu nueva contraseña: "," por favor no la compartas con nadie y cambiala cuando inicies sesión."];
                    $errPalabras = ["El email de recuperación de contraseña no pudo ser enviado, intentelo de nuevo mas tarde"]; 
                    break;
            }

            //Si se ha enviado el formulario de recuperación de contra
            if (isset($_POST["correo"])){

                $correo = CGeneral::addSlashes($_POST["correo"]);
                $nif = CGeneral::addSlashes($_POST["nif"]);
                $usr = new Registro();

                //Si el correo se encuentra en la base de datos de nuestros usuarios
                if ($usr->buscarPor(array("where"=>"email = '$correo' and nif = '$nif'"))){

                    $contra = Login::emailRecuperacion($correo,$mensaje);

                    if (is_string($contra)){
                        $_SESSION["aleatoria"] = $contra;
                        $_SESSION["id"] = $nif;
                        Sistema::app()->irAPagina(array("logueo","ConfirmarRecepcion"));
                    }
                    else
                        Sistema::app()->PaginaError("504",$errPalabras[0]);

                    return;
                }

            }

            echo $this->dibujaVistaParcial("olvido",["palabras"=>$palabras],true);
            return;
        }

        //Acción para confirmar la recepción del correo de recuperación
        public function accionConfirmarRecepcion(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["en","Check your email inbox and confirm the password recovery email reception of our team",
                                 "Email received","Cancel"];
                    break;

                default: 
                    $palabras = ["es","Compruebe la bandeja de entrada en su correo electrónico y confirme si ha recibido el email de recuperación de nuestri equipo",
                                 "Correo recibido","Cancelar"]; 
                    break;
            }

            if ($_POST){

                $acl = Sistema::app()->ACL();

                $cod = $acl->getCodUsuario($_SESSION["id"]);
                $acl->setContrasenia($cod, $_SESSION["aleatoria"]);
    
                unset($_SESSION["id"]);
                unset($_SESSION["aleatoria"]);

                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            echo $this->dibujaVistaParcial("confirmarRecepcion",["palabras"=>$palabras],true);
            return;
        }

        //Accion para acceder a mi cuenta
        public function accionMiCuenta(){
            $acceso = Sistema::app()->acceso();

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Your account","Hello","here you will find all the information about your profile",
                                "My data","Next trips","Trips history"];
                    break;

                default: 
                    $palabras = ["Tu cuenta","Hola","aquí encontraras toda la información sobre tu perfil",
                                "Mis datos","Próximos viajes","Historial de viajes"]; 
                    break;
            }

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

                $this->dibujaVista("cuenta",array("nombre"=>$var,"op"=>$opciones,"palabras"=>$palabras),"Mi cuenta");
            }
                
            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));
        }

        //Acción para consultar los datos del usuario logueado
        public function accionMisDatos(){

            $acceso = Sistema::app()->acceso();
            $acl = Sistema::app()->ACL();

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Data account","ID","User type","Email","Town","Address","Name","Subname","Birth date",
                                 "Modify password","New password","Current password","Save and exit"];
                    break;

                default: 
                    $palabras = ["Datos de la cuenta","NIF","Tipo de usuario","Email","Población","Dirección","Nombre","Apellido","Fecha de nacimiento",
                                 "Modificar contraseña","Nueva contraseña","Contraseña actual","Guardar y salir"]; 
                    break;
            }

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
                $this->dibujaVista("cuenta_datos",["modelo"=>$usr,"rol"=>$rol,"palabras"=>$palabras],"Datos de cuenta");
            }

            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));
        }

        //Acción para que el usuario consulte sus viajes pasados/proximos (segun op GET)
        public function accionViajes(){

            $acceso = Sistema::app()->acceso();

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Date","Hour","Class","Destiny","Ticket",
                                 "Cancel ticket","You're about to cancel the ticket with the destiny: ", "With departure date: ","Are you sure you want to proceed with the operation?"];
                    $campos = ["clase_en","destino_en"];
                    $errPalabras = ["The page you're looking for can't be found"]; 
                    break;

                default: 
                    $palabras = ["Fecha","Hora","Clase","Destino","Billete",
                                 "Borrar billete","Estas a punto de anular el billete con destino: ", "Con fecha de salida: ","¿Estás seguro de que deseas proceder con la operación?"]; 
                    $campos = ["clase","destino"];
                    $errPalabras = ["La página web solicitada no ha sido encontrada"]; 
                    break;
            }

            if ($acceso->hayUsuario()){

                if (!isset($_GET["op"])){
                    Sistema::app()->paginaError("404",$errPalabras[0]);
                    return;
                }

                if ($_GET["op"]!="1" && $_GET["op"]!="2"){
                    Sistema::app()->paginaError("404",$errPalabras[0]);
                    return;
                }
                
                //Si es 1, son los viajes posteriores a la fecha, sino son los anteriores a la fecha
                $operando = $_GET["op"]=="1"?">=":"<";

                $var = CGeneral::addSlashes($acceso->getNif());
                $fec_actual = date("Y-m-d");

                $var = Sistema::app()->BD()->crearConsulta("SELECT {$campos[0]}, 
                                                                   {$campos[1]}, 
                                                                   codigo,
                                                                   fecha_salida,
                                                                   hora_salida
                                                                   FROM perfiles_vuelos 
                                                                   WHERE `nif`='$var' 
                                                                   AND `borrado`='0' 
                                                                   AND `fecha_salida` $operando '$fec_actual'")->filas();

                for ($i=0; $i < count($var) ; $i++)
                    $var[$i] = array_values($var[$i]);
                
                $url = Sistema::app()->generaURL(array("compra","ImprimirBillete"));

                $this->dibujaVista("proximosViajes",array("billetes"=>$var,"url"=>$url, "op"=>$_GET["op"], "palabras"=>$palabras),"Billetes");

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