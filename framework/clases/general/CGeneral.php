<?php


	class CGeneral{
		
		public static function fechaMysqlANormal($fecha)
		{
			$fechaAux=explode("/",$fecha);
			if (count($fechaAux)==3)
			    return $fecha;
			
			$fecha=explode("-", $fecha);
			$fecha=date('d/m/Y',mktime(0,0,0,$fecha[1],$fecha[2],$fecha[0]));
			
			return $fecha;
		}

		public static function fechaNormalAMysql($fecha)
		{
			$fechaAux=explode("-",$fecha);
			if (count($fechaAux)==3)
			    return $fecha;
			
			$fecha=explode("/", $fecha);
			$fecha=date('Y-m-d',mktime(0,0,0,$fecha[1],$fecha[0],$fecha[2]));
			
			return $fecha;
			
		}

		public static function passwordSegura($passwd, $longitud){
			$patron = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,10}$/";
	
			if (preg_match($patron,$passwd)!==1)
				return "La contraseña debe contener al menos una minúscula, mayúscula, un dígito y tener entre 6 y 10 caracteres.";
		
			else if (strlen($passwd)>$longitud)
				return "La contraseña no puede ser superior a $longitud caracteres.";

			else 
				return true;
			}

		public static function peticionCurl($url, $tipo ="POST", $data=array(), $proxy=false){

			//creo una sesión CUrl
			$enlaceCurl = curl_init();

			$parametros = "";

			foreach ($data as $clave => $valor) 
				$parametros .= $clave."=".$valor."&";
				
			$parametros = substr($parametros,0,-1);

			
			//Si la petición es de tipo POST
			if ($tipo=="POST"){
				curl_setopt($enlaceCurl,CURLOPT_URL,$url);
				curl_setopt($enlaceCurl, CURLOPT_POST, 1);
				curl_setopt($enlaceCurl,CURLOPT_POSTFIELDS,$parametros);
				curl_setopt($enlaceCurl, CURLOPT_HEADER, 0);
			}

			//Si la petición es de tipo GET
			if ($tipo=="GET"){
				$url .= "?".$parametros;
				curl_setopt($enlaceCurl,CURLOPT_URL,$url);
			}

			//Si el proxy está activado activamos esta opción
			if ($proxy)
				curl_setopt($enlaceCurl, CURLOPT_PROXY, "192.168.2.254:3128");


			//Se habilita el retorno de datos
			curl_setopt($enlaceCurl, CURLOPT_RETURNTRANSFER, 1);

			//Se ejecuta la petición
			$datos = curl_exec($enlaceCurl);

			//Se cierra la sesión
			curl_close($enlaceCurl);

			//Se devuelven los datos
			return $datos;
		}
		
		/**
		 * Permite escapar una cadena . Los caracteres que se 
		 * escapan son '
		 * 
		 * @param string $cadena
		 * @return string
		 * 
		 */
		public static function addSlashes($cadena)
		{
			return str_replace("'", "''", $cadena);
		}
		
		
		/**
		 * Elimina el escape para una cadena 
		 * 
		 * @param string $cadena 
		 * @return string
		 * 
		 */
		public static function stripSlashes($cadena)
		{
			return str_replace("''", "'", $cadena);
		}
		
		
		
	}
