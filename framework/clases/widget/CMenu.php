<?php

class CMenu extends CWidget{
    
    private $_links;
 
    public function __construct($links=array())
    {
        $this->_links = $links;
    }

    public function dibujaApertura()
    {
        echo CHTML::dibujaEtiqueta("div",array("id"=>"fondo"),null,false).PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        echo CHTML::dibujaEtiqueta("div",array("id"=>"menu"),null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("ul",array("class"=>"list-group list-group-flush"),null,false).PHP_EOL;

        foreach ($this->_links as $clave => $link) 
            echo $link.PHP_EOL;
        
    }

    public function dibujaFin()
    {
        echo CHTML::dibujaEtiquetaCierre("ul").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
    }

    public function dibujate()
    {
        $this->dibujaApertura();
        $this->dibujaFin();
    }
}
?>