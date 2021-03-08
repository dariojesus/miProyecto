/*------------------------Parte de script general para cualquier parte con barra de navegación y menu-------------------------*/
var $botonMenu = $("#btnMenu");
var $menu = $("#menu");
var $fondo = $("#fondo");

//Abrir menu
$botonMenu.click(
    function () {
        $fondo.css("height", window.innerHeight + "px");
        $fondo.css("width", window.innerWidth + "px");
        $menu.css("width", "250px");
        $menu.css("display", "block");
    }
)

//Cerrar menu
$fondo.click(
    function () {
        $fondo.css("width", "0px");
        $menu.css("display", "none");
        $menu.css("width", "0px");
    }
)

/*----------------------------------------------Control del frame y visibilidad (Cuentas)--------------------------------------------------------------- */

//Cerrar frame
$("#btnFrame").click(function(){
    $("#fondoFrame").css("visibility","collapse");
    $("#fondoFrame").css("opacity","0");
    location.reload();
});

//Abrir frame
$("a.utilidad").click(function(){
    $("#fondoFrame").css("visibility","visible");
    $("#fondoFrame").css("opacity","1");
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
    $("#logNombre").val(obtenerCookie("usuario"));
}


$("#acceder").click(function () {
    //Si el check de recordar esta marcado, creamos la cookie
    if (document.getElementById("recordar").checked) {

        let tiempo = 3600 * 24;
        let nombre = document.getElementById("logNombre").value;
        document.cookie = "usuario=" + nombre + "; max-age=" + tiempo;
    }
});

/*------------------------------------------Script para la compra de un billete---------------------------------------------------*/

//Funciones para dirigirse a las paginas correspondientes de dicho elemento
$("div.destino").click(function(){
    window.location = $(this).data("location");
});

$("section.billete").click(function(){
    window.location = $(this).data("location");
});

//Función para obtener el precio de una clase mediante una peticion fetch
$("#claseSeleccionada").change(function(){
    let cod = $("#claseSeleccionada option:selected").val();

     //Se crea la promesa con fetch para establecer la conexion
     fetch("http://www.miproyecto.es/api/ClaseDatos?codigo="+cod, {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            //Esto devuelve una promesa (aunque ponga texto)
            response.json()

                //Se crea una subpromesa para recibir los datos ahora si
                .then(function (resp) {
                   $("#precio").val(resp[0].precio+"€");
                })
                .catch(function (e) {
                    console.log("Data error:" + e);
                });
        })
        .catch(err => {
            console.log("Error:" + err);
        });

});

/*----------------------------------------Script de registro del service worker---------------------------------------------------*/

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
    navigator.serviceWorker.register('/worker.js').then(function(registration) {
    
    console.log('Registro del ServiceWorker con éxito: ', registration.scope);
    }, function(err) {

    console.log('Registro del ServiceWorker falló: ', err);
    });
    });
   }