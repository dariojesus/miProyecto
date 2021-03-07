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

        //Accion para acceder a mi cuenta
        public function accionMiCuenta(){
            $acceso = Sistema::app()->acceso();

            //Si estas logueado accedes a tu cuenta, sino no tienes permiso
            if ($acceso->hayUsuario()){

                $var = $acceso->getNif();
                $var = Sistema::app()->BD()->crearConsulta("SELECT `nombre`, `apellidos` FROM perfiles WHERE `nif`='$var'")->fila();
                $var = $var["nombre"]." ".$var["apellidos"];

                $prox = Sistema::app()->generaURL(array("logueo","Viajes"));

                $this->dibujaVista("cuenta",array("nombre"=>$var,"link3"=>$prox),"Mi cuenta");
            }
                
            else
                Sistema::app()->irAPagina(array("logueo","Formulario"));
        }

        //Acción para que el usuario consulte sus proximos viajes
        public function accionViajes(){
            $acceso = Sistema::app()->acceso();

            if ($acceso->hayUsuario()){
                $var = CGeneral::addSlashes($acceso->getNif());
                $var = Sistema::app()->BD()->crearConsulta("SELECT * FROM perfiles_vuelos WHERE `nif`='$var'")->filas();
                $url = Sistema::app()->generaURL(array("compra","ImprimirBillete"));

                $this->dibujaVista("proximosViajes",array("billetes"=>$var,"url"=>$url),"Proximos viajes");

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