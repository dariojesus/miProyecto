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
                $usuarios[$cont]["borrado"] = $usuarios[$cont]["borrado"]===1? "Si":"No";
            }

            echo $this->dibujaVistaParcial("crudUsuarios",["usr"=>$usuarios],true).PHP_EOL;
        }

        //Acción encargada de llamar a las operaciones agregar/mostrar/modificar/eliminar
        public function accionControl(){

            if (isset($_GET["codigo"])){
                $codigo = $_GET["codigo"];
                echo $this->dibujaVistaParcial("controlUsuarios",array("codigo"=>$codigo),true).PHP_EOL;
            }

            else{
                Sistema::app()->paginaError(505,"No se ha podido recoger el usuario con el que operar.");
                return;
            }
        }

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

        public function accionModificar(){


        }

        public function accionBorrar(){


        }

        //$datos = $usuario->getNombre();
        //$datos = $_POST[$datos];
        //Sistema::app()->irAPagina(array("gestion","Modificar"));
	
	}