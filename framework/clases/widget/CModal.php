<?php

class CModal extends CWidget{
    
    private $_id = "";
    private $_titulo="";
    private $_contenido="";
    private $_linkAccion="";
 
    public function __construct($id,$titulo,$contenido="",$linkAccion="#")
    {
        $this->_id=$id;
        $this->_titulo=$titulo;
        $this->_contenido=$contenido;
        $this->_linkAccion=$linkAccion;
    }

    public function dibujaApertura()
    {
        echo CHTML::dibujaEtiqueta("div", array(
                                                "class"=>"modal fade", 
                                                "id"=>$this->_id,
                                                "data-bs-backdrop"=>"static",
                                                "data-bs-keyboard"=>"false",
                                                "tabindex"=>"-1",
                                                "aria-labelledby"=>"etiquetaModal",
                                                "aria-hidden"=>"true"),
                                    null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("div",array("class"=>"modal-dialog"),null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("div",array("class"=>"modal-content"),null,false).PHP_EOL;
    }

    public function dibujaCabecera(){

        echo CHTML::dibujaEtiqueta("div",array("class"=>"modal-header"),null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("h5",array("class"=>"modal-title", "id"=>"etiquetaModal"),$this->_titulo).PHP_EOL;
        echo CHTML::botonHtml("",array("class"=>"btn-close","data-bs-dismiss"=>"modal", "aria-label"=>"Cerrar")).PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
    }

    public function dibujaContenido(){
        echo CHTML::dibujaEtiqueta("div",array("class"=>"modal-body"),$this->_contenido).PHP_EOL;
    }

    public function dibujaPie(){
        echo CHTML::dibujaEtiqueta("div",array("class"=>"modal-footer"),null,false).PHP_EOL;
        echo CHTML::botonHtml("Cancelar",array("class"=>"btn btn-danger", "data-bs-dismiss"=>"modal")).PHP_EOL;
        echo CHTML::link("Confirmar",$this->_linkAccion,array("class"=>"btn btn-success")).PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
    }

    public function dibujaFin()
    {
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
    }

    public function dibujate()
    {
        $this->dibujaApertura();
        $this->dibujaCabecera();
        $this->dibujaContenido();
        $this->dibujaPie();
        $this->dibujaFin();
    }


}
?>