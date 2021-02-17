<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="icon" type="image/png" href="/imagenes/logo/16.png"/>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

	<!--Scrip de JQuery-->
	<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="/estilos/miEstilo.css">
	<script src="/javascript/miJs.js" defer></script>

	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>

<div id="fondo"></div>

<div id="menu">
	<ul class="list-group list-group-flush">
		<?php
		$acceso = Sistema::app()->acceso();

		if (!$acceso->hayUsuario())
			echo CHTML::link("Iniciar sesion", ["logueo", "formulario"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		else
			echo CHTML::link("Mi cuenta", ["logueo", "MiCuenta"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
			
		echo CHTML::link("Inicio", ["inicial", "Principal"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		echo CHTML::link("Opción 2", "#", ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		echo CHTML::link("Opción 3", "#", ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

		if ($acceso->hayUsuario())
			echo CHTML::link("Logout",["logueo","QuitarRegistro"],["class"=>"list-group-item list-group-item-action list-group-item-danger"]);
		?>
	</ul>
</div>

<nav>
	<a class="nav-link" aria-current="page" id="btnMenu"><img src="/imagenes/logo/menu.png"></a>
</nav>

<?php echo $contenido; ?>

<footer>
	<div class="accordion accordion-flush">
		<div class="accordion-item">
			<h2 class="accordion-header">
				<button class="accordion-button collapsed blanco" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
					Sobre nosotros
				</button>
			</h2>
			<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
				<div class="accordion-body">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis blanditiis
					nostrum natus quod ipsa cumque nemo accusamus saepe itaque optio quia reiciendis dignissimos ratione,
					perspiciatis vitae dicta laborum pariatur vero.</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header">
				<button class="accordion-button collapsed blanco" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
					Protección de datos y cookies
				</button>
			</h2>
			<div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
				<div class="accordion-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus, nemo
					inventore? Pariatur, a odio minima facilis dolor, deserunt saepe dolores itaque accusamus minus
					reiciendis
					cumque qui, alias asperiores fuga nemo.</div>
			</div>
		</div>
		<div class="accordion-item">
			<h2 class="accordion-header">
				<button class="accordion-button collapsed blanco" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
					Condiciones de uso
				</button>
			</h2>
			<div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
				<div class="accordion-body">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iure soluta fugit
					unde
					qui dolor ullam eveniet esse. Assumenda nostrum quibusdam molestias aperiam. Dolores perspiciatis
					molestiae
					voluptas aut similique cupiditate a?</div>
			</div>
		</div>
	</div>
	<div class="empresa">
		<div id="copyright">
			<img src="/imagenes/logo/64.png">
			<p>
				<b>The horizons company</b><br>
				<i>Todos los derechos reservados</i>
			</p>
		</div>
		<div>
			<a href="#"><img src="/imagenes/social/twitter.png" alt="" srcset=""></a>
			<a href="#"><img src="/imagenes/social/insta.png" alt="" srcset=""></a>
			<a href="#"><img src="/imagenes/social/facebook.png" alt="" srcset=""></a>
		</div>
	</div>
</footer>
</body>
</html>