/*--------------------------------------------------Script del menú de navegación y filtro---------------------------------------------*/
var $botonMenu = $("#btnMenu");
var $menu = $("#menu");
var $fondo = $("#fondo");
var $btnF = $("#btnFiltro");
var $filtro = $("#filtro");

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

$btnF.bind("click", aparece);

//Se despliega el filtro (mobile)
function aparece(){
    $filtro.css("left","3%");
    $btnF.unbind("click", aparece);
    $btnF.bind("click", desapararece);
}

//Se repliega el filtro (mobile)
function desapararece(){
    $filtro.css("left","-100%");
    $btnF.unbind("click", desapararece);
    $btnF.bind("click", aparece);
}

/*---------------------------------------------------Script de los destinos----------------------------------------------*/

//Animación para agrandar el destino
function agrandar() {
    $(this).children(".datos").slideUp(500);
    $(this).animate({height:"200px"},500);
}

//Animación para volver el destino al tamaño normal
function normalizar(){
    $(this).children(".datos").slideDown(500);
    $(this).animate({height:"150px"},500);
}

//Al cargar la ventana de un destino van apareciendo los billetes uno a uno
$(window).on("load",function(){

    let billetes = $("#billetes").children(".billete");
    
    for (let i=0 ; i < billetes.length ; i++){

        let cont = i+1;

        setTimeout(() => {
            $(billetes[i]).show("slow");
        }, 500*cont);
    }
});


$(".destinoPaisaje").click(function(){
    window.location = $(this).data("location");
});

$(".destinoPaisaje").on("mouseenter", agrandar);
$(".destinoPaisaje").on("mouseleave", normalizar);
    
/*----------------------------------------------Script del frame y su visibilidad (Cuentas)--------------------------------------------------------------- */

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

//Si el check de recordar esta marcado, creamos la cookie
$("#acceder").click(function () {
    
    if (document.getElementById("recordar").checked) {

        let tiempo = 3600 * 24;
        let nombre = document.getElementById("logNombre").value;
        document.cookie = "usuario=" + nombre + "; max-age=" + tiempo;
    }
});

/*------------------------------------------Script para la compra de un billete---------------------------------------------------*/

$("section.billete").click(function(){
    window.location = $(this).data("location");
});

$("#boarData,#userData").click(progresa);

//Función para ir avanzando en la barra de progreso y visibilidad de las tarjetas
function progresa(){

    //Barra de progreso
    $(".progress-bar.bg-actual").first().addClass("bg-success");
    $(".progress-bar.bg-actual").first().removeClass("bg-actual");

    $(".progress-bar.bg-dis").first().addClass("bg-actual");
    $(".progress-bar.bg-dis").first().removeClass("bg-dis");

    //Visibilidad de tarjetas
    let $actual = $("section.actual");

    $actual.addClass("invisible");
    $actual.next().removeClass("invisible");
    $actual.next().addClass("actual");
    $actual.removeClass("actual");
}

//Función para obtener el precio de una clase mediante una peticion fetch
$("#claseSeleccionada").change(function(){
    let cod = $("#claseSeleccionada option:selected").val();

     //Se crea la promesa con fetch para establecer la conexion
     fetch("/api/ClaseDatos?codigo="+cod, {
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

// if ('serviceWorker' in navigator) {
//     window.addEventListener('load', function() {
//     navigator.serviceWorker.register('/worker.js').then(function(registration) {
    
//     console.log('Registro del ServiceWorker con éxito: ', registration.scope);
//     }, function(err) {

//     console.log('Registro del ServiceWorker falló: ', err);
//     });
//     });
//    }

/*--------------------------------------Script para el cambio de idioma------------------------------------------------------*/

$("#idiomaWeb").change(function(){
    let idioma = $("#idiomaWeb option:selected").val();
    document.cookie = "lang="+idioma+";path=/";
    location.reload();
});