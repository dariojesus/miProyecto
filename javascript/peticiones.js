/*Script para peticiones AJAX
*/

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

//Función para cargar billetes con pocas plazas haciendo una llamada a mi propia API
function cargarUltimos() {

    fetch("/api/VuelosDisponibles?limite=4&borrado=0&disponibles=1&fullData", {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            response.json()

                .then(function (resp) {

                    //A partir de la cookie obtenemos el lenguaje
                    let pal;

                    switch(obtenerCookie("lang")){
                        case ("en"):pal = ["remainings",7];break;
                        default:pal = ["plazas restantes",6];break;
                    }
                            
                    for (let index = 0; index < resp.length; index++) {

                        let datos = convierteJsonArray(resp[index]);

                        let img = `/imagenes/${datos[6].toLowerCase()}-sq.png`;
                        let url = `/compra/Compra?codigo=${datos[0]}`;
                                              
                        $("#seccion1").append(`<div class='destino' data-location='${url}'>`
                            +"<div>"
                                +"<h3><b>"+datos[pal[1]]+"</b></h3>"
                                +"<h5>"+datos[1]+"</h5>"
                                +"<h5>"+datos[2]+"</h5>"
                                +"<h6>"+datos[4]+" "+pal[0]+"</h6>"
                            +"</div>"
                            +`<aside style='background-image: url(${img})'></aside>`
                        +"</div>");
                    }

                    $("div.destino").click(function(){
                        window.location = $(this).data("location");
                    });
                })
                .catch(function (e) {
                    console.log("Data error:" + e);
                });
        })
        .catch(err => {
            console.log("Error:" + err);
        });
}

//Función útil para convertir un JSON en un array
function convierteJsonArray(json){

    let array = [];

    for (const indx in json) 
        array.push(json[indx]);
    
    return array;  
}

//Función para obtener los planetas y rellenar la datalist
function cargaBarraBusqueda(){

    let idioma = obtenerCookie("lang");

    fetch(`/api/PlanetasLista?idioma=${idioma}`, {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            response.json()

                .then(function (resp) {

                    for (const nombre in resp) 
                        $("#listaPlanetas").append(`<option value='${nombre}'>${nombre}</option>`);
                })
                .catch(function (e) {
                    console.log("Data error:" + e);
                });
        })
        .catch(err => {
            console.log("Error:" + err);
        });
}

cargarUltimos();
cargaBarraBusqueda();