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
            echo $this->dibujaVistaParcial("registro",array(),true).PHP_EOL;
        }
		
	}