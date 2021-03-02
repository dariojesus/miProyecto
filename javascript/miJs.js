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

/*--------------------------------------------Script para el control de cookies---------------------------------------------------*/

//Función para obtener el valor de una clave dada (cookie)
function obtenerCookie(clave) {
    var name = clave + "=";
    var ca = document.cookie.split(';');

    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return "";
}

//Si la cookie existe...ponemos los datos en los campos correspondientes
if (obtenerCookie("usuario") != ""){
    document.getElementById("logNombre").value = obtenerCookie("usuario");
}


$("#acceder").click(function () {
    //Si el check de recordar esta marcado, creamos la cookie
    if (document.getElementById("recordar").checked) {

        let tiempo = 3600 * 24;
        let nombre = document.getElementById("logNombre").value;
        document.cookie = "usuario=" + nombre + "; max-age=" + tiempo;
    }
});