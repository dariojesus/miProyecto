<?php
	 
	class logueoControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto ="formulario";
        }

		public function accionFormulario(){
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

        public function accionRegistro(){
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

        public function accionMiCuenta(){

            $this->dibujaVista("cuenta",array(),"Mi cuenta");
        }
		
	}