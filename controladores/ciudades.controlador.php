<?php 

 class ControladorCiudades
 {
	/*=======================================
	 CREAR CIUDADES A GUARDAR
	 =====================================*/
	static public function ctrCrearCiudad($datos)
	{
		if(isset($datos))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos))
			{
				
				$tabla="ciudades";
				$item="DESCRIPCION_CIUDAD";
							
			$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CIUDAD");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    $token=$token.$ValorMaximo["maximo"];
 				$datos= array("ciudad"=>strtoupper($datos),
 							  "token"=>$token);

				$respuesta=ModeloCiudades::mdlIngresarCiudad($tabla,$datos,$item);
				
				// var_dump($respuesta);
				if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
					}else if($respuesta=='exist'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
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

	/*=======================================
	 MOSTRAR CIUDADES
	 =====================================*/
	static public function ctrMostrarCiudad($item,$valor)
	{
		$tabla="ciudades";
		$order="DESCRIPCION_CIUDAD ASC";
		$respuesta=ModeloCiudades::mdlMostrarCiudad($tabla,$item,$valor,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR CIUDADES
	=============================================*/

	static public function ctrEditarCiudad($datos){

		if(isset($datos["ciudad"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["ciudad"]))
			{
				
				$tabla="ciudades";
				$item="DESCRIPCION_CIUDAD";
				
				$datos= array("ciudad"=>strtoupper($datos["ciudad"]),
 							  "token"=>$datos["token"]);

				$respuesta=ModeloCiudades::mdlEditarCiudad($tabla,$datos,$item);
				
					
					if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');
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
	BORRAR CIUDADES
	=============================================*/

	static public function ctrBorrarCiudad($datos){

		if(isset($datos)){

			$tabla ="ciudades";
			$valor = $datos;
			$item = "TOKEN_CIUDAD";
			
			$respuesta = ModeloVarios::mdlEliminarVario($tabla,$item, $valor);
			
					if ($respuesta=='ok'){
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