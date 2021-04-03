var $nif = $("#nif");
var $nombre = $("#nombre");
var $apellidos = $("#apellidos");
var $nacimiento = $("#nacimiento");
var $email = $("#email");
var $poblacion = $("#poblacion");
var $direccion = $("#direccion");
var $contra = $("#contra");

var palabras;

//Control del idioma de los errores
switch(obtenerCookie("lang")){

    case ("en"): palabras = ["Check your ID have a valid format (8 digits, 1 capital letter)",
                             "The name can't be empty or is too long",
                             "The subname can't be empty or it's contain special characters",
                             "The date can't be later than actual date",
                             "Check that your email is valid",
                             "The town field can't be empty or have more of 30 characters",
                             "The emails doesn't match",
                             "The field can't be empty",
                             "The direction can't be empty or have more of 30 characters",
                             "The password must have at least one capital letter, one lower case letter, one digit and be between 6 and 10 characters long ",
                             "The passwords doesn't match"];
                             break;

    default: palabras = ["Comprueba que tu DNI tiene un formato válido (8 dígitos, 1 letra mayúscula)",
                            "El nombre no puede estar vacío o es demasiado largo",
                            "El apellido no puede estar vacío o contener caracteres especiales",
                            "La fecha no puede ser posterior a la de hoy",
                            "Comprueba que tu email tiene un formato correcto",
                            "Eñ campo dirección no puede estar vacío o tener mas de 30 caracteres",
                            "Los emails no coinciden",
                            "El campo no puede estar vacío",
                            "La dirección no puede estar vacía o tener mas de 30 caracteres",
                            "La contraseña debe contener al menos una minúscula, mayúscula, un dígito <br> y tener entre 6 y 10 caracteres",
                            "Las contraseñas no coinciden"];
                            break;
}


//Se agregan los eventos on focus
$nif.on("focus",limpiarEA);
$nombre.on("focus",limpiarEA);
$apellidos.on("focus",limpiarEA);
$nacimiento.on("focus",limpiarEA);
$email.on("focus",limpiarEA);
$("#emailRepetido").on("focus",limpiarEA);
$poblacion.on("focus",limpiarEA);
$direccion.on("focus",limpiarEA);
$contra.on("focus",limpiarEA);
$("#contraRepetida").on("focus",limpiarEA);


//Comprobación del DNI
$nif.on("focusout",function () {
    let re = /^[0-9]{8}[A-Z]{1}$/;

    if (re.test($nif.val()))
        $nif.addClass("acierto");
    else{
        $nif.addClass("error");
        $("<div class='error'>"+palabras[0]+"</div>").insertAfter($nif);
    }      
});

//Comprobación del nombre
$nombre.on("focusout",function(){

    let nombre = $nombre.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,30}$/gmi;

    if(!re.test(nombre)){
        $nombre.addClass("error");
        $("<div class='error'>"+palabras[1]+"</div>").insertAfter($nombre);
    }
    else
        $nombre.addClass("acierto");
});

//Comprobación de apellidos
$apellidos.on("focusout",function(){

    let apellidos = $apellidos.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,50}$/gmi;

    if(!re.test(apellidos)){
        $apellidos.addClass("error");
        $("<div class='error'>"+palabras[2]+"</div>").insertAfter($apellidos);
    }
    else
        $apellidos.addClass("acierto");
});

//Comprobación de fecha de nacimiento
$nacimiento.on("focusout",function(){
    let fecha = $nacimiento.val();

    let hoy = new Date();
    fecha = new Date(fecha);

    if ((fecha - hoy) > 0){
        $nacimiento.addClass("error");
        $("<div class='error'>"+palabras[3]+"</div>").insertAfter($nacimiento);
    }
    else
        $nacimiento.addClass("acierto");
});

//Comprobación del email
$email.on("focusout",function(){
    let re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (!re.test($email.val().trim())){
        $email.addClass("error");
        $("<div class='error'>"+palabras[4]+"</div>").insertAfter($email);
    }
    else
        $email.addClass("acierto");

});

//Comprobación de población
$poblacion.on("focusout",function(){  

    let poblacion = $poblacion.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ0-9 ]{2,30}$/gmi;

    if(!re.test(poblacion)){
        $poblacion.addClass("error");
        $("<div class='error'>"+palabras[5]+"</div>").insertAfter($poblacion);
    }
    else
        $poblacion.addClass("acierto");
})

//Re-comprobación del email
$("#emailRepetido").on("focusout",function(){

    let mail1 = $email.val();
    let mail2 = $(this).val();

    if (!mail1.localeCompare(mail2)==0){
        $(this).addClass("error");
        $("<div class='error'>"+palabras[6]+"</div>").insertAfter($(this));
    }
    else if (mail1===""){
        $(this).addClass("error");
        $("<div class='error'>"+palabras[7]+"</div>").insertAfter($(this));
    }
    else
        $(this).addClass("acierto");
});

//Comprobación del campo direccion
$direccion.on("focusout",function(){

    let direccion = $direccion.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ0-9 ]{2,30}$/gmi;

    if(!re.test(direccion)){
        $direccion.addClass("error");
        $("<div class='error'>"+palabras[8]+"</div>").insertAfter($direccion);
    }
    else
        $direccion.addClass("acierto");

});

//Comprobación de contraseña
$contra.on("focusout",function(){

    let contra = $contra.val();
    let re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,10}$/;

    if(!re.test(contra)){
        $contra.addClass("error");
        $("<div class='error'>"+palabras[9]+"</div>").insertAfter($contra);
    }
    else
        $contra.addClass("acierto");

});

//Re-comprobación de la contraseña
$("#contraRepetida").on("focusout",function(){
    let contra1 = $contra.val();
    let contra2 = $(this).val();

    if (!contra1.localeCompare(contra2)==0){
        $(this).addClass("error");
        $("<div class='error'>"+palabras[10]+"</div>").insertAfter($(this));
    }

    else if (contra1===""){
        $(this).addClass("error");
        $("<div class='error'>"+palabras[7]+"</div>").insertAfter($(this));
    }
    else
        $(this).addClass("acierto");
});

//Para limpiar errores/aciertos del formulario
function limpiarEA () {

    let hermanos = $(this).siblings();

    if(hermanos.length > 0){
        
        for (let cont=0; cont < hermanos.length; cont++){

            if ($(hermanos[cont]).hasClass("error"))
                $(hermanos[cont]).remove();
        }

        $(this).removeClass("error");
    }
    else if ($(this).hasClass("acierto"))
        $(this).removeClass("acierto");
}

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