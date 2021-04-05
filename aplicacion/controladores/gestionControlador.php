<?php
	 
     //Controlador con acciones respectivas a la cuenta
	class gestionControlador extends CControlador{

        //Constructor por defecto que llama al crud
        public function __construct(){
            $this->accionDefecto ="crudUsuarios";
        }

        //Acción para mostrar el crud de usuarios
        public function accionCrudUsuarios(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Yes","Login","My account","Home","Trips","Trips management","Users management","Logout",
                                 "ID","Email","Name","Subname","Birth date","Town","Address","Deleted","Action",
                                 "Delete user","You are about to delete the user ","Are you sure you want to proceed with the operation?"]; 
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Si","Iniciar sesión","Mi cuenta","Inicio","Viajes","Gestión de viajes","Gestión de usuarios","Logout",
                                 "NIF","Email","Nombre","Apellidos","Fecha de nacimiento","Población","Dirección","Borrado","Acción",
                                 "Borrar usuario","Está a punto de borrar el usuario ","¿Seguro que quiere proceder con la operación?"];
                    $errPalabras = ["No tiene permisos para acceder a esta acción"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(4)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            $usuarios = new Registro();
            $usuarios = $usuarios->buscarTodos();

            for ($cont=0; $cont < count($usuarios) ; $cont++) { 
                $usuarios[$cont]["fecha_nacimiento"] = CGeneral::fechaMysqlANormal($usuarios[$cont]["fecha_nacimiento"]);
                $usuarios[$cont]["borrado"] = $usuarios[$cont]["borrado"]==1? $palabras[0]:"No";
            }

            echo $this->dibujaVistaParcial("crudUsuarios",["usr"=>$usuarios,"palabras"=>$palabras],true).PHP_EOL;
        }

        //Acción para agregar un usuario nuevo
        public function accionAgregar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Personal data","ID","Name","Subname","Birth date",
                                 "Contact data","Email","Town","Address",
                                 "Security","Password","Repeat password","Role",
                                 "Add"]; 
                    $errPalabras = ["You don't have permissions to do this action"];
                    break;

                default: 
                    $palabras = ["Datos personales","NIF","Nombre","Apellidos","Fecha de nacimiento",
                                "Datos de contacto","Email","Población","Dirección",
                                "Seguridad","Contraseña","Repetir contraseña","Rol",
                                "Agregar"];
                    $errPalabras = ["No tiene permisos para realizar esta acción"];
                    break;
            }


            $usuario = new Registro();
            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(4)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            $roles = Login::dameRoles();
            $datos = $usuario->getNombre();
            $acl = Sistema::app()->ACL();
            $exito = "";
            
            if (isset($_POST[$datos]) && isset($_POST["contrasenna"]) && isset($_POST["rol"])){

                $usuario->setValores($_POST[$datos]);
                $exito = CGeneral::passwordSegura($_POST["contrasenna"],50);
                $rol = CGeneral::addSlashes($_POST["rol"]);

                //Si los datos son validos y la contraseña cumple los requisitos, se guarda en usuarios y en perfiles
                if ($usuario->validar() &&  $exito === true && $acl->existeRole($rol)){

                    if ($usuario->guardar()){
                    $contra = $_POST["contrasenna"];

                    $acl->anadirUsuario($usuario->nif, $contra, $rol);
                    Sistema::app()->irAPagina(array("gestion","Correcta"));
                    return;
                    }
                }
            }

            echo $this->dibujaVistaParcial("agregarUsuarios",array("modelo"=>$usuario,"roles"=>$roles,"palabras"=>$palabras),true).PHP_EOL;
            return;
        }

        //Acción para mostrar la información de un usuario
        public function accionMostrar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Personal data","ID","Name","Subname","Birth date",
                                 "Contact data","Email","Town","Address",
                                 "Account data","Deleted"]; 
                    $errPalabras = ["You don't have permissions to do this action",
                                    "Ups, the data about the user can't be retrieved"];
                    break;

                default: 
                    $palabras = ["Datos personales","NIF","Nombre","Apellidos","Fecha de nacimiento",
                                "Datos de contacto","Email","Población","Dirección",
                                "Datos de la cuenta","Borrado"];
                    $errPalabras = ["No tiene permisos para realizar esta acción",
                                    "Ups, no se ha podido recuperar la información de dicho usuario"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(4)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            //Se busca y recupera el usuario en el caso de que exista
            $usuario = new Registro();
            $exito = $usuario->buscarPorId($_GET["codigo"]);

            if (!$exito){
                Sistema::app()->paginaError(505,$errPalabras[1]);
                return;
            }

            else{
                $usuario->fecha_nacimiento = CGeneral::fechaNormalAMysql($usuario->fecha_nacimiento);
                echo $this->dibujaVistaParcial("mostrarUsuarios",array("modelo"=>$usuario,"palabras"=>$palabras),true).PHP_EOL;
                return;
            }
        }

        //Acción para modificar la información de un usuario
        public function accionModificar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $palabras = ["Personal data","ID","Name","Subname","Birth date",
                                 "Contact data","Email","Town","Address",
                                 "Account data","Deleted","Modify"]; 
                    $errPalabras = ["You don't have permissions to do this action",
                                    "Ups, the data about the user can't be retrieved"];
                    break;

                default: 
                    $palabras = ["Datos personales","NIF","Nombre","Apellidos","Fecha de nacimiento",
                                "Datos de contacto","Email","Población","Dirección",
                                "Datos de la cuenta","Borrado","Modificar"];
                    $errPalabras = ["No tiene permisos para realizar esta acción",
                                    "Ups, no se ha podido recuperar la información de dicho usuario"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(4)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

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
                    Sistema::app()->irAPagina(array("gestion","Correcta"));
                    return;
                }
            }

            //El usuario no se ha encontrado en la base de datos
            if (!$exito){
                Sistema::app()->paginaError(505,$errPalabras[1]);
                return;
            }

            else{
                $usuario->fecha_nacimiento = CGeneral::fechaNormalAMysql($usuario->fecha_nacimiento);
                echo $this->dibujaVistaParcial("modificarUsuarios",array("modelo"=>$usuario,"palabras"=>$palabras),true).PHP_EOL;
                return;
            }

        }

        //Acción para borrar un usuario
        public function accionBorrar(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $errPalabras = ["You don't have permissions to do this action",
                                    "Ups, the data about the user can't be retrieved"];
                    break;

                default: 
                    $errPalabras = ["No tiene permisos para realizar esta acción",
                                    "Ups, no se ha podido recuperar la información del usuario"];
                    break;
            }

            $acceso = Sistema::app()->acceso();

            //Si no estas logueado te manda al login
            if (!$acceso->hayUsuario()){
                Sistema::app()->irAPagina(array("logueo","Formulario"));
                return;
            }

            //Si no tienes permiso, te da error
            if (!$acceso->puedePermisos(5)){
                Sistema::app()->paginaError(401,$errPalabras[0]);
            }

            //Si viene un código por el get
            if (isset($_GET["codigo"])){

                $codigo = CGeneral::addSlashes($_GET["codigo"]);
                $usuario = new Registro();
                $exito = $usuario->ejecutarSentencia("SELECT nif FROM `perfiles` WHERE `cod_perfil` = '$codigo'");

                //Si el código que viene no existe
                if (!$exito){
                    Sistema::app()->paginaError(505,$errPalabras[1]);
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

            Sistema::app()->paginaError(505,$errPalabras[1]);
            return;
            
        }
        
        //Acción para mostrar una animación de que todo ha ido bien
        public function accionCorrecta(){

            switch($_COOKIE["lang"]){
                case("en"): 
                    $mensaje = "Action done sucefully, please close this window to refresh the data.";

                    break;

                default: 
                    $mensaje = "Acción realizada correctamente, puede cerrar esta pestaña para actualizar los datos.";
                    break;
            }


            echo $this->dibujaVistaParcial("correcto",array("mensaje"=>$mensaje),true).PHP_EOL;
            return;
        }
	}