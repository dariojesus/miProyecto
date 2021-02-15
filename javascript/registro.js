var $nif = $("#nif");
var $nombre = $("#nombre");
var $apellidos = $("#apellidos");
var $nacimiento = $("#nacimiento");
var $email = $("#email");


//Se agregan los eventos on focus
$nif.on("focus",limpiarEA);
$nombre.on("focus",limpiarEA);
$apellidos.on("focus",limpiarEA);
$nacimiento.on("focus",limpiarEA);
$email.on("focus",limpiarEA);
$("#emailRepetido").on("focus",limpiarEA);

//Comprobación del DNI
$nif.on("focusout",function () {
    let re = /^[0-9]{8}[A-Z]{1}$/;

    if (re.test($nif.val()))
        $nif.addClass("acierto");
    else{
        $nif.addClass("error");
        $("<div class='error'>Compruebe su DNI</div>").insertAfter($nif);
    }      
});

//Comprobación del nombre
$nombre.on("focusout",function(){

    let nombre = $nombre.val().trim();

    if(nombre.length == 0 || nombre.length > 30){
        $nombre.addClass("error");
        $("<div class='error'>El nombre no puede estar vacío o es demasiado largo</div>").insertAfter($nombre);
    }
    else
        $nombre.addClass("acierto");
});

//Comprobación de apellidos
$apellidos.on("focusout",function(){

    let apellidos = $apellidos.val().trim();

    if(apellidos.length == 0 || apellidos.length > 30){
        $apellidos.addClass("error");
        $("<div class='error'>El apellido no puede estar vacío o es demasiado largo</div>").insertAfter($apellidos);
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
        $("<div class='error'>La fecha no puede ser posterior a la de hoy.</div>").insertAfter($nacimiento);
    }
    else
        $nacimiento.addClass("acierto");
});

//Comprobación del email
$email.on("focusout",function(){
    let re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    if (!re.test($email.val().trim())){
        $email.addClass("error");
        $("<div class='error'>Compruebe que es un email válido.</div>").insertAfter($email);
    }
    else
        $email.addClass("acierto");

});

//Re-comprobación del email
$("#emailRepetido").on("focusout",function(){

    let mail1 = $email.val();
    let mail2 = $(this).val();

    if (!mail1.localeCompare(mail2)==0){
        $(this).addClass("error");
        $("<div class='error'>Los emails no coinciden.</div>").insertAfter($(this));
    }
    else
        $(this).addClass("acierto");
});


//Para limpiar errores/aciertos del formulario
function limpiarEA () {

    if($(this).next().hasClass("error")){
        $(this).next().remove();
        $(this).removeClass("error");
    }
    else if ($(this).hasClass("acierto"))
        $(this).removeClass("acierto");
}

