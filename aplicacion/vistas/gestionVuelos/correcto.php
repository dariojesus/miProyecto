<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>


    <script src="/javascript/registro.js" defer></script>
</head>
<style>
    article {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        display: grid;
        grid-template-columns: min-content;
        row-gap: 3%;
    }

    section {
        opacity: 0;
        text-align: center;

        animation-name: aparecer;
        animation-delay: 1.5s;
        animation-duration: .5s;
        animation-fill-mode: forwards;
    }


    div.circulo {
        height: 150px;
        width: 150px;
        background-color: darkcyan;
        border-radius: 120px;

        animation-name: rotar;
        animation-duration: 3s;
    }

    div.l1 {
        position: relative;
        margin: 0;
        top: 50%;
        left: 15%;
        background-color: white;
        width: 0px;
        height: 20px;
        transform: rotateZ(45deg);
        border-radius: 50px;

        animation-name: crecer;
        animation-duration: 2s;
        animation-delay: 1s;
        animation-fill-mode: forwards;
    }

    div.l2 {
        position: relative;
        margin: 0;
        width: 0px;
        top: 26%;
        left: 29%;
        background-color: white;
        height: 20px;
        transform: rotateZ(-45deg);
        border-radius: 50px;

        animation-name: crecer2;
        animation-duration: 2s;
        animation-delay: 1s;
        animation-fill-mode: forwards;
    }

    @keyframes crecer {
        from {
            width: 0px;
        }

        to {
            width: 55px;
        }
    }

    @keyframes crecer2 {
        from {
            width: 0px;
        }

        to {
            width: 110px;
        }
    }

    @keyframes rotar {
        from {
            transform: rotateY(90deg);
        }

        to {
            transform: rotateY(none);
        }
    }

    @keyframes aparecer {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

<body>
    <article>
        <div class="circulo">
            <div class="l1"></div>
            <div class="l2"></div>
        </div>
        <section>
            <p><?php echo $mensaje ?></p>
        </section>
    </article>
</body>

</html>