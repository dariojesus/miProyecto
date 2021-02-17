<?php
class Registro extends CActiveRecord{

    protected function fijarNombre(){
        return "registro";
    }

    protected function fijarAtributos(){
        
        return array("nif", "nombre", "apellidos", "fecha_nacimiento",
                     "email", "poblacion", "direccion", "contrasenna");
    }

    protected function fijarDescripciones(){

        return array("nif"=>"NIF",
                     "nombre"=>"Nombre",
                     "apellidos"=>"Apellidos",
                     "fecha_nacimiento"=>"Fecha de nacimiento",
                     "email"=>"Email",
                     "poblacion"=>"Población",
                     "direccion"=>"Dirección",
                     "contrasenna"=>"Contraseña");
    }

    protected function fijarRestricciones(){
        
        return array(
                    array("ATRI"=>"nif,nombre,apellidos,fecha_nacimiento,email,poblacion,direccion,contrasenna","TIPO"=>"REQUERIDO"),
                
                    array(
                        "ATRI"=>"nif",
                        "TIPO"=>"FUNCION",
                        "FUNCION"=>"compruebaDNI",
                        "TAMANIO"=>"10",
                        "MENSAJE"=>"El NIF no puede tener mas de 10 caracteres."
                    ),

                    array(
                        "ATRI"=>"nombre",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"30",
                        "MENSAJE"=>"El nombre no puede tener mas de 30 caracteres."
                    ),

                    array(
                        "ATRI"=>"apellidos",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"50",
                        "MENSAJE"=>"El apellido no puede tener mas de 50 caracteres."
                    ),

                    array(
                        "ATRI"=>"fecha_nacimiento",
                        "TIPO"=>"FUNCION",
                        "FUNCION"=>"validaFecha",
                    ),

                    array("ATRI"=>"email", "TIPO"=>"FUNCION", "FUNCION"=>"validaEmail"),

                    array(
                        "ATRI"=>"email",
                        "TIPO"=>"EMAIL",
                        "TAMANIO"=>"50",
                        "MENSAJE"=>"El email no puede tener mas de 50 caracteres."
                    ),

                    array(
                        "ATRI"=>"poblacion",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"50",
                        "MENSAJE"=>"La poblacion no puede tener mas de 50 caracteres."
                    ),

                    array(
                        "ATRI"=>"direccion",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"50",
                        "MENSAJE"=>"La direccion no puede tener mas de 50 caracteres."
                    ),

                    array("ATRI"=>"contrasenna","TIPO"=>"FUNCION","FUNCION"=>"compruebaContra"),

                    array(
                        "ATRI"=>"contrasenna",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"50",
                        "MENSAJE"=>"La contraseña no puede tener mas de 50 caracteres."
                    )
                );
    }

    protected function afterCreate(){
        $this->nif = "";
        $this->nombre = "";
        $this->apellidos = "";
        $this->fecha_nacimiento = "";
        $this->email="";
        $this->poblacion="";
        $this->direccion="";
        $this->contrasenna="";
    }

    public function validaEmail(){
        $existe = Sistema::app()->BD()->crearConsulta("SELECT `cod_perfil` FROM perfiles WHERE `email` = '".$this->email."'");
        $existe = $existe->filas();

        if ($existe)
            $this->setError("email","El email ya se encuentra registrado en nuestra web.");
    }

    public function compruebaContra(){

        $patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,10}$/";

        if (preg_match($patron,$this->contrasenna)!==1)
            $this->setError("contrasenna","La contraseña debe contener al menos una minúscula, mayúscula, un dígito y tener entre 6 y 10 caracteres.");
    }

    public function compruebaDNI(){

        $existe = Sistema::app()->BD()->crearConsulta("SELECT `cod_usuario` FROM usuarios WHERE `nif` = '".$this->nif."'");
        $existe = $existe->filas();

        if (!CValidaciones::validaDNI($this->nif,$partes))
            $this->setError("nif","Formato de DNI incorrecto, compruebelo de nuevo.");

        if ($existe)
            $this->setError("nif","El DNI ya se encuentra registrado en nuestra web.");
    }

    public function validaFecha(){
        
        $fecha_dada = DateTime::createFromFormat("Y-m-d",$this->fecha_nacimiento);
        $fecha_actual = DateTime::createFromFormat("Y-m-d",date("Y-m-d"));

        $fecha_limite = strtotime("-18 year");
        $fecha_limite = date("Y-m-d",$fecha_limite);

        if ($fecha_dada < $fecha_limite)
            $this->setError("fecha_nacimiento","Debe ser mayor de 18 años para proceder con el registro.");

        else if ($fecha_dada >= $fecha_actual)
            $this->setError("fecha_nacimiento","La fecha de nacimiento no puede ser superior a la actual.");
    }

}
?>