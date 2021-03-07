<?php
	 
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

}