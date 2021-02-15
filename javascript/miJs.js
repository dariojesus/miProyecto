var $botonMenu = $("#btnMenu");
var $menu = $("#menu");
var $fondo = $("#fondo");

$botonMenu.click(
    function () {
        $fondo.css("height",window.innerHeight+"px");
        $fondo.css("width",window.innerWidth+"px");
        $menu.css("width","250px");
        $menu.css("display","block");
    }
)

$fondo.click(
    function () {
        $fondo.css("width","0px");
        $menu.css("display","none");
        $menu.css("width","0px");
    }
)