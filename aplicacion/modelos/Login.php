<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once ("./librerias/PHPMailer-master/src/Exception.php");
require_once ("./librerias/PHPMailer-master/src/PHPMailer.php");
require_once ("./librerias/PHPMailer-master/src/SMTP.php");
require_once ("./librerias/PHPMailer-master/src/OAuth.php");

class Login extends CActiveRecord {

    protected function fijarNombre(){
        return "login";
    }

    protected function fijarTabla(){
        return "usuarios";
    }

    protected function fijarId(){
        return "cod_usuario";
    }

    protected function fijarAtributos(){
        return array("cod_usuario","nif","contrasenna");
    }

    protected function fijarDescripciones(){
        return array("nif"=>"NIF", "contrasenna"=>"Contraseña");
    }

    protected function fijarRestricciones(){

        return array(

                    array("ATRI"=>"nif,contrasenna","TIPO"=>"REQUERIDO"),

                    array("ATRI"=>"nif", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaDNI"),

                    array("ATRI"=>"nif",
                          "TIPO"=>"CADENA",
                          "TAMANIO"=>10,
                          "MENSAJE"=>"El nif debe tener 10 caracteres o menos."),

                    array("ATRI"=>"contrasenna","TIPO"=>"FUNCION","FUNCION"=>"compruebaLogin"),

                    array("ATRI"=>"contrasenna",
                          "TIPO"=>"CADENA",
                          "TAMANIO"=>20)

        );
    }

    protected function afterCreate(){
        $this->nif="";
        $this->contrasenia="";
    }

    public function compruebaDNI(){

        if (!CValidaciones::validaDNI($this->nif,$partes))
            $this->setError("nif","Formato de DNI incorrecto, compruebelo de nuevo.");
        
    }

    public static function dameRoles(){

        $acl = Sistema::app()->ACL();
        return $acl->dameRoles();
    }

    public function compruebaLogin(){

        $acl = Sistema::app()->ACL();

        //Si el usuario es valido se procede a autenticar
        if ($acl->esValido($this->nif,$this->contrasenna)){

            $codigo = $acl->getCodUsuario($this->nif);
            $this->autenticar($codigo, $acl);
        }

        else{
            $this->setError("contrasenna","Compruebe su nick y contraseña.");
        }
        
    }

    private function autenticar($codigo, $acl){

        $acceso = Sistema::app()->acceso();
        $permisos = $acl->getPermisos($codigo);
        $acceso->registrarUsuario($this->nif,$permisos);
    }

    //Función estática para enviar un mail de recuperación al correo pasado por parámetro
    public static function emailRecuperacion($correo,$mensaje){

        $contra = Self::creaPassRandom(9);
        $mail = new PHPMailer(true);

            try {
                //Configuración del servidor
                $mail->isSMTP();
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Host = "smtp.gmail.com";

                //Cuenta
                $mail->Username = 'cuentapruebahorizons@gmail.com';
                $mail->Password = 'Hor.1234';

                //Puerto 
                $mail->Port = 465;
            
                //Enviador y receptor
                $mail->setFrom('cuentapruebahorizons@gmail.com', 'Horizons');
                $mail->addAddress($correo, 'Admin user');
                       
                //Contenido
                $mail->isHTML(true);
                $mail->Subject = "Password recovery";
                $mail->Body    = "{$mensaje[0]}<b>$contra</b>{$mensaje[1]}";
            
                $mail->send();
                return $contra;

            } catch (Exception $e) {
                //$mail->ErrorInfo;
                return false;
            }
    }

    //Función privada para crear una contraseña aleatoria de num caracteres
     public static function creaPassRandom($num){

        $pass = "";
        $posibles[0] = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"];
        $posibles[1] = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];
        $posibles [2] = ["0","1","2","3","4","5","6","7","8","9"];
    
        for ($i = 0 ; $i < $num ; $i++){
            $arr = random_int(0,2);
            $car = random_int(0,count($posibles[$arr])-1);
            $pass .= $posibles[$arr][$car];
        }
                    
        return $pass;
    }
}