<?php

class Vuelos extends CActiveRecord{

protected function fijarNombre(){
    return "destinos";
}

protected function fijarTabla(){
    return "vuelos";
}

protected function fijarId(){
    return "cod_vuelo";
}

protected function fijarAtributos(){
    
    return array("cod_vuelo","fecha_salida","hora_salida","compannia","plazas","borrado","cod_destino");
}

protected function fijarDescripciones(){

    return array("cod_vuelo"=>"Codigo de vuelo",
                 "fecha_salida"=>"Fecha de salida",
                 "hora_salida"=>"Hora de salida",
                 "compannia"=>"Compañia",
                 "plazas"=>"Plazas",
                 "borrado"=>"Borrado",
                 "cod_destino"=>"Codigo de destino");
}

protected function fijarRestricciones(){
    
    return array(

                array(
                    "ATRI"=>"cod_vuelo",
                    "TIPO"=>"ENTERO"
                ),

                array("ATRI"=>"fecha_salida, hora_salida, compannia, plazas, cod_destino","TIPO"=>"REQUERIDO"),

                array(
                    "ATRI"=>"fecha_salida",
                    "TIPO"=>"FUNCION",
                    "FUNCION"=>"compruebaFecha"
                ),

                array(
                    "ATRI"=>"hora_salida",
                    "TIPO"=>"HORA"
                ),

                array(
                    "ATRI"=>"compannia",
                    "TIPO"=>"CADENA",
                    "TAMANIO"=>"30",
                    "MENSAJE"=>"El nombre de la compañia no debe ser superior a 30 caracteres."
                ),

                array(
                    "ATRI"=>"plazas",
                    "TIPO"=>"ENTERO",
                    "MIN"=>"1",
                    "MENSAJE"=>"Las plazas del vuelo no pueden ser inferiores a 1."
                ),

                array(
                    "ATRI"=>"borrado",
                    "TIPO"=>"ENTERO",
                    "MIN"=>"0",
                    "MAX"=>"1",
                    "MENSAJE"=>"El borrado solo puede ser 1 o 0."
                ),

                array("ATRI"=>"cod_destino", "TIPO"=>"FUNCION", "FUNCION"=>"compruebaDestino"),

                array(
                    "ATRI"=>"cod_destino",
                    "TIPO"=>"ENTERO",
                    "MIN"=>"1",
                    "MENSAJE"=>"El codígo de destino no puede ser inferior a 1."
                )
    );
}

protected function compruebaFecha(){

    $fecha_dada = DateTime::createFromFormat("Y-m-d", $this->fecha_salida);
    $fecha_actual = DateTime::createFromFormat("Y-m-d", date("Y-m-d"));

    if ($fecha_dada < $fecha_actual)
        $this->setError("fecha_salida", "La fecha introducida no puede ser inferior a la actual.");
}

protected function compruebaDestino(){

    if (!Planetas::devuelvePlanetas($this->cod_destino))
        $this->setError("cod_destino","No existe destino con el código dado.");

}

protected function afterCreate(){
    $this->fecha_salida = "";
    $this->hora_salida = "";
    $this->compannia = "";
    $this->plazas = 0;
    $this->borrado= 0;
    $this->cod_destino = 0;
}

public function fijarSentenciaInsert(){

    $fec = CGeneral::addSlashes($this->fecha_salida);
    $hor = CGeneral::addSlashes($this->hora_salida);
    $com = CGeneral::addSlashes($this->compannia);
    $plz = CGeneral::addSlashes($this->plazas);
    $bor = CGeneral::addSlashes($this->borrado);
    $des = CGeneral::addSlashes($this->cod_destino);

    $sentencia = "INSERT INTO  vuelos (`fecha_salida`, `hora_salida`, `compannia`, `plazas`, `borrado`, `cod_destino`)".
                                "values ('$fec', '$hor', '$com', '$plz', '$bor', '$des')";

    return $sentencia;
}

public function fijarSentenciaUpdate(){

    $codigo = CGeneral::addSlashes($this->cod_vuelo);

    $fec = CGeneral::addSlashes($this->fecha_salida);
    $hor = CGeneral::addSlashes($this->hora_salida);
    $com = CGeneral::addSlashes($this->compannia);
    $plz = CGeneral::addSlashes($this->plazas);
    $bor = CGeneral::addSlashes($this->borrado);
    $des = CGeneral::addSlashes($this->cod_destino);

    $sentencia = "UPDATE vuelos SET `fecha_salida` = '$fec'".
                                        ", `hora_salida` ='".$hor."'".
                                        ", `compannia` ='".$com."'".
                                        ", `plazas` ='".$plz."'".
                                        ", `borrado` ='".$bor."'".
                                        ", `cod_destino` ='".$des."'".
                                        "  where `cod_vuelo` ='".$codigo."'";

    return $sentencia;
}

}
?>