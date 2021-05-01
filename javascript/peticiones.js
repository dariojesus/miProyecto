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

    fetch("/api/VuelosDisponibles?limite=4&fullData", {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            response.json()

                .then(function (resp) {

                    //A partir de la cookie obtenemos el lenguaje
                    let pal;

                    switch(obtenerCookie("lang")){
                        case ("en"): pal = "remainings"; break;
                        default: pal = "plazas restantes"; break;
                    }
                            
                    for (let index = 0; index < resp.length; index++) {

                        let img = `/imagenes/${resp[index].nombre.toLowerCase()}-sq.jpg`;
                        let url = `/compra/Compra?codigo=${resp[index].cod_vuelo}`;
                                              
                        $("#seccion1").append(`<div class='destino' data-location='${url}'>`
                            +"<div>"
                                +"<h3>"+resp[index].nombre+"</h3>"
                                +"<h5>"+resp[index].fecha_salida+"</h5>"
                                +"<h5>"+resp[index].hora_salida+"</h5>"
                                +"<h6>"+resp[index].plazas+" "+pal+"</h6>"
                            +"</div>"
                            +`<div style='background-image: url(${img})'></div>`
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

//Función para obtener la imagen del día a traves de la API de la NASA
function cargarFotoDelDia(){

        fetch("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY", {
            headers: { "Content-Type": "application/json" },
            method: "GET"
        })
            .then(function (response) {
                response.json()
                    .then(function (resp) {

                        if (resp.hdurl){
                            let imagen = "url('"+resp.hdurl+"')";
                            $("#cabecera").css("background",imagen);
                        }
                    })
                    .catch(function (e) {
                        console.log("Data error:" + e);
                    });
            })
            .catch(err => {
                console.log("Error:" + err);
            });
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
                        $("#listaPlanetas").append(`<option value='${nombre}' />`);
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
cargarFotoDelDia();
cargaBarraBusqueda();