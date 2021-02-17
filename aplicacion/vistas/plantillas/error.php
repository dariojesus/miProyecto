<?php
	header("HTTP/1.1 $numError $mensaje");
	header("Status: $numError $mensaje");
	echo $mensaje;
?>