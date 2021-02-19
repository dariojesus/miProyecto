<?php
class Planetas extends CActiveRecord{

    protected function fijarNombre(){
        return "planetas";
    }

    protected function fijarTabla(){
        return "destinos";
    }

    protected function fijarId(){
        return "cod_destino";
    }

    protected function fijarAtributos(){
        
        return array("cod_destino","nombre","descripcion","duracion_viaje","clima","foto");
    }

    protected function fijarDescripciones(){

        return array("cod_destino"=>"Codigo",
                     "nombre"=>"Nombre",
                     "descripcion"=>"Descripcion",
                     "duracion_viaje"=>"Duracion del viaje",
                     "clima"=>"Clima",
                     "foto"=>"Foto");
    }

    protected function fijarRestricciones(){

        return array(

                    array(
                        "ATRI"=>"cod_destino",
                        "TIPO"=>"ENTERO"
                    ),

                    array("ATRI"=>"nombre,descripcion,duracion_viaje,clima,foto", "TIPO"=>"REQUERIDO"),

                    array("ATRI"=>"nombre", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaPlaneta"),

                    array(
                        "ATRI"=>"nombre",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"30",
                        "MENSAJE"=>"El nombre del planeta no puede tener mas de 30 caracteres."
                    ),

                    array(
                        "ATRI"=>"descripcion",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"10",
                        "MENSAJE"=>"La descripcion del planeta no puede tener mas de 100 caracteres."
                    ),

                    array(
                        "ATRI"=>"duracion_viaje",
                        "TIPO"=>"ENTERO",
                        "MIN"=>"0",
                        "MENSAJE"=>"La duración del viaje no puede ser inferior a 1 hora."
                    ),

                    array (
                        "ATRI"=>"clima",
                        "TIPO"=>"CADENA",
                        "TAMANIO"=>"30",
                        "MENSAJE"=>"El campo clima no puede tener mas de 30 caracteres."
                    )
        );
    }

    protected function afterCreate(){

        $this->nombre="";
        $this->descripcion="";
        $this->duracion_viaje=0;
        $this->clima="";
        $this->foto="";
    }

    public function compruebaPlaneta(){

        $existe = Sistema::app()->BD()->crearConsulta("SELECT `cod_destino` FROM destinos WHERE `nombre` = '".$this->nombre."'");
        $existe = $existe->filas();

        if ($existe)
            $this->setError("nif","El planeta ya se encuentra registrado en los destinos.");
    }

    public function fijarSentenciaInsert(){

        $nom = CGeneral::addSlashes($this->nombre);
        $des = CGeneral::addSlashes($this->descipcion);
        $dur = CGeneral::addSlashes($this->duracion_viaje);
        $cli = CGeneral::addSlashes($this->clima);
        $pic = CGeneral::addSlashes($this->foto);

        $sentencia = "INSERT INTO  destinos (`nombre`, `descripcion`, `duracion_viaje`, `clima`, `foto`)".
                                    "values ('$nom', '$des', '$dur', '$cli', '$pic')";

        return $sentencia;
    }

    public function fijarSentenciaUpdate(){

        $codigo = CGeneral::addcslashes($this->cod_destino);
        $nom = CGeneral::addSlashes($this->nombre);
        $des = CGeneral::addSlashes($this->descipcion);
        $dur = CGeneral::addSlashes($this->duracion_viaje);
        $cli = CGeneral::addSlashes($this->clima);
        $pic = CGeneral::addSlashes($this->foto);

        $sentencia = "UPDATE destinos SET `nombre` = '$nom'".
                                            ", `descripcion` ='".$des."'".
                                            ", `duracion_viaje` ='".$dur."'".
                                            ", `clima` ='".$cli."'".
                                            ", `foto` ='".$pic."'".
                                            "  where `cod_destino` ='".$cod."'";

        return $sentencia;
    }

}
?>