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

/*------------------------------Parte de script para mostrar información de los destinos a viajar-----------------------------*/

$("#filtro").click(function(){
    $(this).css("background-color","grey");
});


//Se le agregan los disparadores a las tarjetas de planetas
var planetas = $("#planetas").children("div.destino");

for (let cont = 0; cont < planetas.length; cont++)
    $(planetas[cont]).click(muestraInfo);

//Funcion para mostrar la info correspondiente al planeta pulsado y ocultar la de los demas
function muestraInfo() {

    let nombre = "#" + $(this).children("div.datos").children("h2").text();
    let visible = $(nombre).siblings(".info").not("[style]");

    if (visible.length != 0)
        $(visible[0]).attr("style", "display:none;");

    $(nombre).removeAttr("style");
}

/*----------------------------------------------Control del frame y visibilidad (Cuentas)--------------------------------------------------------------- */

$("#btnFrame").click(function(){
    $("#fondoFrame").css("visibility","collapse");
    $("#fondoFrame").css("opacity","0");
});

$("a.utilidad").click(function(){
    $("#fondoFrame").css("visibility","visible");
    $("#fondoFrame").css("opacity","1");
});