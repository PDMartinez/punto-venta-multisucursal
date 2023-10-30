<?php 

 class ControladorMarcas
 {
	/*=======================================
	 CREAR SUB CATEGORIAS A GUARDAR
	 =====================================*/
	static public function ctrCrearMarca($datos)
	{
		if(isset($datos))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos))
			{

				date_default_timezone_set("America/Asuncion");
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;
				
				$tabla="marcas";
									
				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_MARCA");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];
				
 				$datos= array("marcas"=>strtoupper($datos),
 							"token"=>$token,
 							"fecha_registro"=>$fechaActual);

				$respuesta=ModeloMarcas::mdlIngresarMarca($tabla,$datos);
				
				
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
	 MOSTRAR MARCAS
	 =====================================*/
	static public function ctrMostrarMarca($item,$valor)
	{
		$tabla="marcas";
		$order="NOMBRE_MARCA ASC";
		$respuesta=ModeloMarcas::mdlMostrarMarca($tabla,$item,$valor,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR MARCAS
	=============================================*/

	static public function ctrEditarMarca($datos){

		if(isset($datos["Marca"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["Marca"]))
			{
				
				$tabla="marcas";
				$item="NOMBRE_MARCA";
				
				$datos= array("Marca"=>strtoupper($datos["Marca"]),
 							  "token"=>$datos["token"]);

				$respuesta=ModeloMarcas::mdlEditarMarca($tabla,$datos,$item);
				
					
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
	BORRAR MARCAS
	=============================================*/

	static public function ctrBorrarMarca($datos){

		if(isset($datos)){

			$tabla ="marcas";
			$valor = $datos;
			$item = "TOKEN_MARCA";
			
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