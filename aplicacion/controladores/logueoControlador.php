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

            //Sino accedes al formulario de registro
            $registro = new Registro();
            $datos = $registro->getNombre();

            if (isset($_POST[$datos])){

                $registro->setValores($_POST[$datos]);

                if ($registro->validar()){
                    echo "Validado correcto";
                    return;
                }
            }

            echo $this->dibujaVistaParcial("registro",array("modelo"=>$registro),true).PHP_EOL;
        }

        //Accion para acceder a mi cuenta
        public function accionMiCuenta(){
            $acceso = Sistema::app()->acceso();

            //Si estas logueado accedes a tu cuenta, sino no tienes permiso
            if ($acceso->hayUsuario()){

                $var = $acceso->getNif();
                $var = Sistema::app()->BD()->crearConsulta("SELECT `nombre`, `apellidos` FROM perfiles WHERE `nif`='$var'")->fila();
                $var = $var["nombre"]." ".$var["apellidos"];

                $this->dibujaVista("cuenta",array("nombre"=>$var),"Mi cuenta");
            }
                
            else
                Sistema::app()->paginaError(500,"Ups, no tiene permiso para acceder a esta página");
        }

        //Accion para logout
        public function accionQuitarRegistro(){
            $acceso = Sistema::app()->acceso();
            $acceso->quitarRegistroUsuario();
            Sistema::app()->irAPagina(array("inicial","Principal"));
        }
		
	}