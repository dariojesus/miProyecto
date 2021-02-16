<?php
class Login extends CActiveRecord {

    protected function fijarNombre(){
        return "login";
    }

    protected function fijarAtributos(){
        return array("nif","contrasenna");
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
}