<?php 

 class ControladorSucursales
 {
	/*=======================================
	 CREAR CATEGORIA A GUARDAR
	 =====================================*/
	static public function ctrCrearSucursal($datos)
	{
		if(isset($datos["sucursal"]))
		{
			$guardarRuta=[""];
			
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["sucursal"])||
			preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ ]+$/', $datos["Encargado"])||
			preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["direccion"])||
			preg_match('/^[0-9]+$/', $datos["verificador"])||
			preg_match('/^[0-9]+$/', $datos["pedidos"])||
			preg_match('/^[0-9]+$/', $datos["remision"])||
			preg_match('/^[0-9()-., ]+$/', $datos["telefono"]))
			{

				if($datos["imgGaleria"] != ""){

			   	$ruta = array();
			   	$guardarRuta = array();

				$galeria = json_decode($datos["imgGaleria"], true);

				for($i = 0; $i < count($galeria); $i++){

					list($ancho, $alto) = getimagesize($galeria[$i]);
					$info = getimagesize($galeria[$i]);

					$nuevoAncho = 940;
					$nuevoAlto = 480;

					/*=============================================
					Creamos el directorio donde vamos a guardar la imagen
					=============================================*/

					$directorio = "../vistas/img/sucursales";	
					$aleatorio = md5(uniqid(rand(),true));
					
					array_push($ruta, strtolower($directorio."/".$aleatorio.".jpg"));

					if ($info['mime'] == 'image/jpeg') {

						$origen = imagecreatefromjpeg($galeria[$i]);
					}else{
						$origen = imagecreatefrompng($galeria[$i]);
					}

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);	

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta[$i]);	

					array_push($guardarRuta, substr($ruta[$i], 3));

				}

			}
				
				$tabla="sucursales";
				$item="PRINCIPAL";
							
				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_SUCURSAL");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];
				
 				$datos = array("sucursal" => strtoupper($datos["sucursal"]),
							"encargado"=>strtoupper($datos["encargado"]),
							"direccion"=>strtoupper($datos["direccion"]),
							"ciudad"=> $datos["ciudad"],
						    "verificador" =>str_replace('.','',($datos["verificador"])),
							"pedidos"=>str_replace('.','',($datos["pedidos"])),
							"remision"=> str_replace('.','',($datos["remision"])),
							"telefono"=>str_replace('.','',($datos["telefono"])),
							"estado"=> $datos["estado"],
							"imagen"=> json_encode($guardarRuta),
			    			"token"=>$token,
			    			"ruc"=>$datos["ruc"],
			    			"principal"=>$datos["principal"]);

 				$respuesta=ModeloSucursales::mdlIngresarSucursal($tabla,$datos,$item);
				
				// var_dump($respuesta);
				if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
					}else if($respuesta=='principal'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ninguna sucursal como principal, por favor seleccione uno');
					}else{
						$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die(); //para parar la aplicacion


			}else
			{

				$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
			}
		}

	}

	/*=============================================
	MOSTRAR CANTIDAD SUCURSAL QUE PUEDE CREAR
	=============================================*/
	static public function ctrMostrarCantidadSucursal($item,$valor)
	{
		$tabla="canti_uso";
		$order="CANT_SUCURSALES ASC";
		$respuesta=ModeloVarios::mdlMostrarVario($tabla,$item,$valor,$order);
		return $respuesta;
	}


	/*=======================================
	 CONSULTAR LOS DATOS
	 =====================================*/
	static public function ctrMostrarSucursal($item,$valor,$var)
	{
		$tabla="sucursales";
		$order="SUCURSAL ASC";
		$respuesta=ModeloSucursales::mdlMostrarSucursal($tabla,$item,$valor,$var,$order);
		return $respuesta;


	}

	/*=======================================
	 CONSULTAR LOS DATOS CON INNER JOIN
	 =====================================*/
	static public function ctrMostrarSucursalInner($item,$valor)
	{
		$tabla="sucursales";
		$tabla1="ciudades";
		$order="SUCURSAL ASC";
		$respuesta=ModeloSucursales::mdlMostrarSucursalInner($tabla,$tabla1,$item,$valor,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarSucursal($datos){

		if(isset($datos["sucursal"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["sucursal"])||
			preg_match('/^[a-zA-ZñÑáÁéÉíÍóÓúÚ ]+$/', $datos["Encargado"])||
			preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["direccion"])||
			preg_match('/^[0-9]+$/', $datos["verificador"])||
			preg_match('/^[0-9]+$/', $datos["pedidos"])||
			preg_match('/^[0-9]+$/', $datos["remision"])||
			preg_match('/^[0-9-]+$/', $datos["ruc"])||
			preg_match('/^[0-9()-., ]+$/', $datos["telefono"]))
			{



			//Eliminar las fotos de la galería de la carpeta
				$guardarRuta=[""];
		
			if($datos["imgGaleriaAntigua"] != "" ){	

				$galeriaBD = json_decode($datos["imgGaleriaAntiguaEstatica"], true);
				
				$galeriaAntigua = explode("," , $datos["imgGaleriaAntigua"]);

				// var_dump("galeria antigua",	$galeriaAntigua);
				// return;
				$guardarRuta = $galeriaAntigua;
		
				$borrarFoto = array_diff($galeriaBD, $galeriaAntigua);

				foreach ($borrarFoto as $key => $valueFoto){
						if($valueFoto!=[""]){
						
					if (!file_exists($valueFoto)) {
						unlink("../".$valueFoto);

					}
				}

				}

			}else{

			if($datos["imgGaleriaAntiguaEstatica"] != '[""]' && $datos["imgGaleriaAntiguaEstatica"] != ""){	

					$galeriaBD = json_decode($datos["imgGaleriaAntiguaEstatica"], true);
				
					foreach ($galeriaBD as $key => $valueFoto){
						if($valueFoto!='[""]'){

							if (!file_exists($valueFoto)) {
								unlink("../".$valueFoto);

							}
						
						}
					}


				}


				
			}
		   	
		   	// Cuando vienen fotos nuevas

		   		if($datos["imgGaleria"] != ""){

			   	$ruta = array();
			   	$guardarRuta = array();

				$galeria = json_decode($datos["imgGaleria"], true);

				for($i = 0; $i < count($galeria); $i++){

					list($ancho, $alto) = getimagesize($galeria[$i]);
					$info = getimagesize($galeria[$i]);
					$nuevoAncho = 940;
					$nuevoAlto = 480;

					/*=============================================
					Creamos el directorio donde vamos a guardar la imagen
					=============================================*/

					$directorio = "../vistas/img/sucursales";	
					$aleatorio = md5(uniqid(rand(),true));
					array_push($ruta, strtolower($directorio."/".$aleatorio.".jpg"));

					if ($info['mime'] == 'image/jpeg') {

						$origen = imagecreatefromjpeg($galeria[$i]);
					}else{
						$origen = imagecreatefrompng($galeria[$i]);
					}

					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);	

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta[$i]);	

					array_push($guardarRuta, substr($ruta[$i], 3));


			}

				// Agregamos las fotos antiguas

				if($datos["imgGaleriaAntigua"] != ""){

					foreach ($galeriaAntigua as $key => $value) {
						
						array_push($guardarRuta, $value);
					}

				}

			}

				
				$tabla="sucursales";
				$item="PRINCIPAL";

				$datos = array("sucursal" => strtoupper($datos["sucursal"]),
							"encargado"=>strtoupper($datos["encargado"]),
							"direccion"=>strtoupper($datos["direccion"]),
							"ciudad"=> $datos["ciudad"],
						    "verificador" =>str_replace('.','',($datos["verificador"])),
							"pedidos"=>str_replace('.','',($datos["pedidos"])),
							"remision"=> str_replace('.','',($datos["remision"])),
							"telefono"=>str_replace('.','',($datos["telefono"])),
							"estado"=> $datos["estado"],
							"imagen"=> json_encode($guardarRuta),
			    			"token"=>$datos["tokensucursal"],
			    			"ruc"=>$datos["ruc"],
			    			"principal"=> $datos["principal"]);

				$respuesta=ModeloSucursales::mdlEditarSucursal($tabla,$datos,$item);
				
					
					if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');
					}elseif($respuesta=='principal'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ninguna sucursal como principal, por favor seleccione uno');
					}else{
						$arrResponse=array('status'=>false,'msg'=> 'No es posible Actualizar los datos.');
					}

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
				
			}else
			{

				$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en ninguno de los campos!');
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
			}

		}

	}



	/*=============================================
	BORRAR CATEGORIA
	=============================================*/

	static public function ctrBorrarSucursal($datos){

		if(isset($datos["idEliminar"])){

			$tabla ="sucursales";
			$valor = $datos["idEliminar"];
			$item = "TOKEN_SUCURSAL";
			
			$respuesta = ModeloVarios::mdlEliminarVario($tabla,$item, $valor);
			
					if ($respuesta=='ok'){

						// Eliminamos fotos de la galería
				if($datos["galeria"]!=""){
						$galeria = explode("," , $datos["galeria"]);
						
						foreach ($galeria as $key => $value) {
						if($value!=[""]){
							
							if (!file_exists($value)) {
								unlink("../".$value);

							}

						}	
						
						
						}
					}
						$arrResponse=array('status'=>true,'msg'=> 'Datos Eliminado Correctamente');
					}else if($respuesta[0]==23000){

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Eliminar el dato, el mismo está siendo usado.');
					}
					else{
						$arrResponse=array('status'=>false,'msg'=> $respuesta[2]);
					}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
		}
		
	}

 }