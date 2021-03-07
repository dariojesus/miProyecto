/*---------------------------------------------Script para peticiones AJAX---------------------------------------------------------*/

//Función para crear billetes con pocas plazas haciendo una llamada a mi propia API
function cargarUltimos() {

    fetch("http://www.miproyecto.es/api/VuelosDisponibles?plazas=20", {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            response.json()

                .then(function (resp) {

                    let longitud = resp.length > 4? 4 : resp.length;

                    for (let index = 0; index < longitud; index++) {
                        
                        $("#seccion1").append("<div class='destino'>"
                        +"<h3>"+resp[index].compannia+"</h3>"
                        +"<h5>"+resp[index].fecha_salida+"</h5>"
                        +"<h5>"+resp[index].hora_salida+"</h5>"
                        +"<h6>"+resp[index].plazas+" plazas</h6>"
                        +"</div>");
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

//Función para obtener la imagen del día a traves de la API de la NASA
function cargarFotoDelDia(){

        fetch("https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY", {
            headers: { "Content-Type": "application/json" },
            method: "GET"
        })
            .then(function (response) {
                response.json()
                    .then(function (resp) {

                        let imagen = "url('"+resp.hdurl+"')";
                        $("#cabecera").css("background",imagen);
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