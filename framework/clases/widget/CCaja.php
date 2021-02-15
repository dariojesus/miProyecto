<?php

class CCaja extends CWidget{

    private $_titulo;
    private $_contenido;
    private $_atributos;

    public function __construct($titulo, $contenido="", $atributosHTML=array())
    {
        $this->_titulo = $titulo;
        $this->_contenido = $contenido;
        $this->_atributos = $atributosHTML;
    }

    public function dibujaApertura()
    {
        $this->_atributos["class"] = "caja";

        echo CHTML::dibujaEtiqueta("div",$this->_atributos,null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("div",["class"=>"titulo"],$this->_titulo,false).PHP_EOL;
        echo CHTML::botonHtml("Mostrar",["onclick"=>"mostrar();"]).PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        echo CHTML::dibujaEtiqueta("div",["class"=>"cuerpo","id"=>"cuerpoFiltro"],null,false).PHP_EOL;
        
    }

    public function dibujaFin()
    {
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        
    }

    public function dibujate()
    {
        return $this->dibujaApertura.$this->dibujaFin;
    }

}

?>