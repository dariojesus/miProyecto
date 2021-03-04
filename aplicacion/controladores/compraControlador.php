<?php
	 
     //Controlador con acciones respectivas a la compra de billetes
	class compraControlador extends CControlador{

        public function __construct(){
            $this->accionDefecto="compra";
        }

        //Acción para proceder a la compra de un billete
		public function accionCompra(){
            
            if (isset($_GET["codigo"])){

                $vuelo = new Vuelos();
                $usuario = new Registro();

                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $vuelo->buscarPorId($codigo);

                $codigo = CGeneral::addSlashes(Sistema::app()->acceso()->getNif());
                $codigo = Sistema::app()->BD()->crearConsulta("SELECT `cod_usuario` FROM usuarios WHERE `nif`='$codigo'")->fila()["cod_usuario"];
                $usuario->buscarPorId($codigo);

                $this->dibujaVista("compraBillete",array("vuelo"=>$vuelo,"usuario"=>$usuario),"Compra de billete");
                return;
            }
            
		}

}