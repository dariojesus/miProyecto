/*---------------------------------------------Script para peticiones AJAX---------------------------------------------------------*/

function cargarUltimos() {

    //Se crea la promesa con fetch para establecer la conexion
    fetch("http://www.miproyecto.es/api/VuelosDisponibles?plazas=20", {
        headers: { "Content-Type": "application/json" },
        method: "GET"
    })
        .then(function (response) {
            //Esto devuelve una promesa (aunque ponga texto)
            response.json()

                //Se crea una subpromesa para recibir los datos ahora si
                .then(function (resp) {

                    let longitud = resp.length > 5? 5 : resp.length;

                    for (let index = 0; index < longitud; index++) {
                        
                        $("#seccion1").append("<div class='vuelo'>"
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

cargarUltimos();