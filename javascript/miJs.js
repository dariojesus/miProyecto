/*------------------------Parte de script general para cualquier parte con barra de navegación y menu-------------------------*/
var $botonMenu = $("#btnMenu");
var $menu = $("#menu");
var $fondo = $("#fondo");

$botonMenu.click(
    function () {
        $fondo.css("height", window.innerHeight + "px");
        $fondo.css("width", window.innerWidth + "px");
        $menu.css("width", "250px");
        $menu.css("display", "block");
    }
)

$fondo.click(
    function () {
        $fondo.css("width", "0px");
        $menu.css("display", "none");
        $menu.css("width", "0px");
    }
)

/*----------------------------------------------Control del frame y visibilidad (Cuentas)--------------------------------------------------------------- */

$("#btnFrame").click(function(){
    $("#fondoFrame").css("visibility","collapse");
    $("#fondoFrame").css("opacity","0");
    location.reload();
});

$("a.utilidad").click(function(){
    $("#fondoFrame").css("visibility","visible");
    $("#fondoFrame").css("opacity","1");
});

/*--------------------------------------------Script para el control de la parte de viajes y destinos--------------------------------------------------- */

$("div.destino").click(function(){
    window.location = $(this).data("location");
});
