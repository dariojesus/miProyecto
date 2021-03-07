<?php
class Billetes extends CActiveRecord{

    protected function fijarNombre(){
        return "billetes";
    }

    protected function fijarTabla(){
        return "billetes";
    }

    protected function fijarId(){
        return "cod_billete";
    }

    protected function fijarAtributos(){
        
        return array("cod_billete","cod_clase","cod_vuelo","cod_perfil","borrado");
    }

    protected function fijarDescripciones(){

        return array("cod_billete"=>"Codigo",
                     "cod_clase"=>"Clase",
                     "cod_vuelo"=>"Codigo de vuelo",
                     "cod_perfil"=>"Codigo de perfil",
                     "borrado"=>"Borrado");
    }

    protected function fijarRestricciones(){

        return array(

                    array(
                        "ATRI"=>"cod_billete",
                        "TIPO"=>"ENTERO"
                    ),

                    array("ATRI"=>"cod_clase, cod_vuelo, cod_perfil", "TIPO"=>"REQUERIDO"),

                    array("ATRI"=>"cod_clase", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaClase"),

                    array("ATRI"=>"cod_vuelo", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaVuelo"),

                    array("ATRI"=>"cod_perfil", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaUsuario")
        );
    }

    protected function afterCreate(){

        $this->cod_clase="";
        $this->cod_vuelo="";
        $this->cod_perfil="";
        $this->borrado=0;
    }

    protected function compruebaClase(){
        $existe = Sistema::app()->BD()->crearConsulta("SELECT `nombre` FROM clases WHERE `cod_clase` = '".$this->cod_clase."'");
        $existe = $existe->filas();

        if (!$existe)
            $this->setError("cod_clase","La clase de asiento seleccionada no está disponible.");
    }

    protected function compruebaVuelo(){
        $existe = Sistema::app()->BD()->crearConsulta("SELECT `compannia` FROM vuelos WHERE `cod_vuelo` = '".$this->cod_vuelo."'".
                                                                                            " and `plazas` > 1".
                                                                                            " and `borrado` = 0");
        $existe = $existe->filas();

        if (!$existe)
            $this->setError("cod_vuelo","El vuelo elegido no se encuentra disponible.");
    }

    protected function compruebaUsuario(){
        $existe = Sistema::app()->BD()->crearConsulta("SELECT `nombre` FROM perfiles WHERE `cod_perfil` = '".$this->cod_perfil."' AND `borrado` = '0'");
        $existe = $existe->filas();

        if (!$existe)
            $this->setError("cod_perfil","El usuario actual no puede comprar billetes.");
    }

    public function fijarSentenciaInsert(){

        $cla = CGeneral::addSlashes($this->cod_clase);
        $vue = CGeneral::addSlashes($this->cod_vuelo);
        $per = CGeneral::addSlashes($this->cod_perfil);
        $bor = CGeneral::addSlashes($this->borrado);

        $sentencia = "INSERT INTO  billetes (`cod_clase`, `cod_vuelo`, `cod_perfil`, `borrado`)".
                                    "values ('$cla', '$vue', '$per', '$bor')";

        return $sentencia;
    }

    public function fijarSentenciaUpdate(){

        $codigo = CGeneral::addSlashes($this->cod_billete);
        $cla = CGeneral::addSlashes($this->cod_clase);
        $vue = CGeneral::addSlashes($this->cod_vuelo);
        $per = CGeneral::addSlashes($this->cod_perfil);
        $bor = CGeneral::addSlashes($this->borrado);

        $sentencia = "UPDATE billetes SET `cod_clase` ='".$cla."'".
                                            ", `cod_vuelo` ='".$vue."'".
                                            ", `cod_perfil` ='".$per."'".
                                            ", `borrado` ='".$bor."'".
                                            "  where `cod_billete` ='".$codigo."'";

        return $sentencia;
    }

}
?>