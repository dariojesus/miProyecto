$('#botcopy-embedder-d7lcfheammjct').append("<script src='https://widget.botcopy.com/js/injection.js' async></script>");

$("body").append("<div class='controlVoz' onclick='init()'></div>");

async function crearModelo(URL) {

    //Se crean las URLS con el modelo y metadatos
    const modelo = URL + "model.json";
    const metadatos = URL + "metadata.json";

    //Se crea el reconocedor de voz, asegurando antes de devolverlo que se ha cargado
    const reconocedor = speechCommands.create("BROWSER_FFT", undefined, modelo, metadatos);
    await reconocedor.ensureModelLoaded();

    //Se devuelve el modelo ya creado
    return reconocedor;
}

async function init() {

    //Cargamos nuestro modelo entrenado de Google Teachable Machine
    const reconocedor = await crearModelo("https://teachablemachine.withgoogle.com/models/41geNOYa2/");

    $(".controlVoz").addClass("animar");

    //Se obtienen las palabras a reconocer del modelo
    const classLabels = reconocedor.wordLabels();

    // listen() devuelve 2 argumentos:
    // 1. Funcion de callback cada vez que se reconoce una palabra
    // 2. Objeto de configuración con campos ajustables

    console.dir(classLabels);

    reconocedor.listen(result => {

        let indice = indiceMayor(result.scores);

        if (indice!=2){
            reconocedor.stopListening();
            $(".controlVoz").removeClass("animar");
            redireccionar(classLabels[indice]);
        }else{
            console.log("ciclo");
        }
        
    }, {
        includeSpectrogram: false,
        probabilityThreshold: 0.70,
        overlapFactor: 0.50
    });

    
}

//Función útil, para encontrar el indice del array con el valor mayor
function indiceMayor(array){

    let mayor = array[2];
    let indice = 0;

    for (let index = 0; index < array.length; index++) {
        if (array[index]>0.90 && array[index]>mayor){
            mayor = array[index];
            indice = index;
        }
    }

    return indice;
}

//Función para redireccionar el navegador segun la label reconocida de la IA
function redireccionar(palabra){

    let url;

    switch(palabra){
        case "Viajes": url = "http://www.miproyecto.es/inicial/Destinos"; break;
        case "Inicio": url = "http://www.miproyecto.es/inicial/Principal"; break;
        case "Cuenta" :url = "http://www.miproyecto.es/logueo/MiCuenta"; break;
    }

    location.replace(url);
}