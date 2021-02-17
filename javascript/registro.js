var $nif = $("#nif");
var $nombre = $("#nombre");
var $apellidos = $("#apellidos");
var $nacimiento = $("#nacimiento");
var $email = $("#email");
var $poblacion = $("#poblacion");
var $direccion = $("#direccion");
var $contra = $("#contra");


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
        $("<div class='error'>Compruebe su DNI</div>").insertAfter($nif);
    }      
});

//Comprobación del nombre
$nombre.on("focusout",function(){

    let nombre = $nombre.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ ]{2,30}$/gmi;

    if(!re.test(nombre)){
        $nombre.addClass("error");
        $("<div class='error'>El nombre no puede estar vacío o es demasiado largo</div>").insertAfter($nombre);
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
        $("<div class='error'>El apellido no puede estar vacío o contener caracteres especiales.</div>").insertAfter($apellidos);
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

//Comprobación de población
$poblacion.on("focusout",function(){  

    let poblacion = $poblacion.val();
    let re = /^[a-zA-ZáéíóúÁÉÍÓÚ0-9 ]{2,30}$/gmi;

    if(!re.test(poblacion)){
        $poblacion.addClass("error");
        $("<div class='error'>La poblacion no puede estar vacía o ser mayor a 30 caracteres.</div>").insertAfter($poblacion);
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
        $("<div class='error'>Los emails no coinciden.</div>").insertAfter($(this));
    }
    else if (mail1===""){
        $(this).addClass("error");
        $("<div class='error'>El campo no puede estar vacío.</div>").insertAfter($(this));
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
        $("<div class='error'>La dirección no puede estar vacía o ser mayor a 30 caracteres.</div>").insertAfter($direccion);
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
        $("<div class='error'>La contraseña debe contener al menos una minúscula, mayúscula, un dígito <br> y tener entre 6 y 10 caracteres</div>").insertAfter($contra);
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
        $("<div class='error'>Las contraseñas no coinciden.</div>").insertAfter($(this));
    }

    else if (contra1===""){
        $(this).addClass("error");
        $("<div class='error'>El campo no puede estar vacío.</div>").insertAfter($(this));
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