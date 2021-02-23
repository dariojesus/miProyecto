<?php
	 
     //Controlador con acciones respectivas a la cuenta
	class gestionControlador extends CControlador{

        //Constructor por defecto que llama al crud
        public function __construct(){
            $this->accionDefecto ="crudUsuarios";
        }

        //Acción para mostrar el crud de usuarios
        public function accionCrudUsuarios(){

            $usuarios = new Registro();
            $usuarios = $usuarios->buscarTodos();

            for ($cont=0; $cont < count($usuarios) ; $cont++) { 
                $usuarios[$cont]["fecha_nacimiento"] = CGeneral::fechaMysqlANormal($usuarios[$cont]["fecha_nacimiento"]);
                $usuarios[$cont]["borrado"] = $usuarios[$cont]["borrado"]==1? "Si":"No";
            }

            echo $this->dibujaVistaParcial("crudUsuarios",["usr"=>$usuarios],true).PHP_EOL;
        }

        //Acción para mostrar la información de un usuario
        public function accionMostrar(){

            //Se busca y recupera el usuario en el caso de que exista
            $usuario = new Registro();
            $exito = $usuario->buscarPorId($_GET["codigo"]);

            if (!$exito){
                Sistema::app()->paginaError(505,"Ups, no se ha podido recuperar la información de dicho usuario.");
                return;
            }

            else{
                $usuario->fecha_nacimiento = CGeneral::fechaNormalAMysql($usuario->fecha_nacimiento);
                echo $this->dibujaVistaParcial("mostrarUsuarios",array("modelo"=>$usuario),true).PHP_EOL;
                return;
            }
        }

        //Acción para modificar la información de un usuario
        public function accionModificar(){

            $acl = Sistema::app()->ACL();
            $usuario = new Registro();
            $datos = $usuario->getNombre();
            $exito = $usuario->buscarPorId($_GET["codigo"]);

            //En el caso de que lleguen los datos por POST se intenta validar
            if (isset($_POST[$datos])){
                $datos = $_POST[$datos];
                $usuario->setValores($datos);

                if($usuario->validar()){
                    $usuario->guardar();
                    $acl->setNif($datos["cod_perfil"],$datos["nif"]);
                    $acl->setBorrado($acl->getCodUsuario($datos["nif"]),$datos["borrado"]);
                    Sistema::app()->irAPagina(array("gestion","CrudUsuarios"));
                    return;
                }
            }

            //El usuario no se ha encontrado en la base de datos
            if (!$exito){
                Sistema::app()->paginaError(505,"Ups, no se ha podido recuperar la información de dicho usuario.");
                return;
            }

            else{
                $usuario->fecha_nacimiento = CGeneral::fechaNormalAMysql($usuario->fecha_nacimiento);
                echo $this->dibujaVistaParcial("modificarUsuarios",array("modelo"=>$usuario),true).PHP_EOL;
                return;
            }

        }

        //Acción para borrar un usuario
        public function accionBorrar(){

            //Si viene un código por el get
            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $usuario = new Registro();
                $exito = $usuario->ejecutarSentencia("SELECT nif FROM `perfiles` WHERE `cod_perfil` = '$codigo'");

                //Si el código que viene no existe
                if (!$exito){
                    Sistema::app()->paginaError(505,"Ups, no se ha podido encontrar el usuario a borrar.");
                    return;
                }

                //Si existe se elimina de perfiles y de usuarios
                else{
                    $acl = Sistema::app()->ACL();
                    $nif = $exito[0]["nif"];

                    $acl->setBorrado($acl->getCodUsuario($nif),1);
                    $usuario->ejecutarSentencia("UPDATE `perfiles` SET `borrado` = '1' WHERE `cod_perfil` = '$codigo'");
                }

                Sistema::app()->irAPagina(array("gestion","CrudUsuarios"));
                return;

            }

            Sistema::app()->paginaError(505,"Ups, no se ha podido encontrar el usuario a borrar.");
            return;
            
        }	
	}