<?php
class Clases extends CActiveRecord{

    protected function fijarNombre(){
        return "clases";
    }

    protected function fijarTabla(){
        return "clases";
    }

    protected function fijarId(){
        return "cod_clase";
    }

    protected function fijarAtributos(){
        
        return array("cod_clase","nombre","precio","caracteristicas");
    }

    protected function fijarDescripciones(){

        return array("cod_clase"=>"Codigo",
                     "nombre"=>"Nombre",
                     "precio"=>"Precio",
                     "caracteristicas"=>"Características");
    }

    protected function fijarRestricciones(){

        return array(

                    array(
                        "ATRI"=>"cod_clase",
                        "TIPO"=>"ENTERO"
                    ),

                    array("ATRI"=>"nombre, precio, caracteristicas", "TIPO"=>"REQUERIDO"),

                    array(
                        "ATRI"=>"nombre", 
                        "TIPO"=>"CADENA", 
                        "TAMANIO"=>30,
                        "MENSAJE"=>"El nombre de la clase no puede ser superior a 30 caracteres."),

                    array(
                        "ATRI"=>"precio", 
                        "TIPO"=>"ENTERO", 
                        "MIN"=>0,
                        "MAX"=>9999,
                        "MENSAJE"=>"El precio del billete no puede ser inferior a 0 ni superior a 9999"),

                    array(
                        "ATRI"=>"caracteristicas", 
                        "TIPO"=>"CADENA", 
                        "TAMANIO"=>100,
                        "MENSAJE"=>"Las descripción no puede tener mas de 100 caracteres.")

        );
    }

    protected function afterCreate(){

        $this->nombre="";
        $this->precio="";
        $this->caracteristicas="";
    }

    public static function dameTiposClases(){
        $array = [];

        $tipos = Sistema::app()->BD()->crearConsulta("SELECT `cod_clase`, `nombre` FROM clases");
        $tipos = $tipos->filas();

        foreach ($tipos as $clave => $valor)
            $array[$valor["cod_clase"]]=$valor["nombre"];

        return $array;
    }

    public function fijarSentenciaInsert(){

        $nom = CGeneral::addSlashes($this->nombre);
        $pre = CGeneral::addSlashes($this->precio);
        $car = CGeneral::addSlashes($this->caracteristicas);

        $sentencia = "INSERT INTO  clases (`nombre`, `precio`, `caracteristicas`)".
                                    "values ('$nom', '$pre', '$car')";

        return $sentencia;
    }

    public function fijarSentenciaUpdate(){

        $codigo = CGeneral::addSlashes($this->cod_clase);
        $nom = CGeneral::addSlashes($this->nombre);
        $pre = CGeneral::addSlashes($this->precio);
        $car = CGeneral::addSlashes($this->caracteristicas);

        $sentencia = "UPDATE clases SET `nombre` ='".$nom."'".
                                            ", `precio` ='".$pre."'".
                                            ", `caracteristicas` ='".$car."'".
                                            "  where `cod_clase` ='".$codigo."'";

        return $sentencia;
    }

}
?>