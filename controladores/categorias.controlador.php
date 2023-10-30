<?php 

 class ControladorCategorias
 {
	/*=======================================
	 CREAR CIUDADES A GUARDAR
	 =====================================*/
	static public function ctrCrearCategoria($datos)
	{
		if(isset($datos))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos))
			{
				date_default_timezone_set("America/Asuncion");
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;

				$tabla="categorias";
				$item="NOMBRE_CATEGORIA";

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_CATEGORIA");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    
				     $token=$token.$ValorMaximo["maximo"];
 				$datos= array("categoria"=>strtoupper($datos),
 							"fecha_registro"=>$fechaActual,
 							  "token"=>$token);

				$respuesta=ModeloCategorias::mdlIngresarCategoria($tabla,$datos,$item);
				
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
	static public function ctrMostrarCategoria($item,$valor)
	{
		$tabla="categorias";
		$order="NOMBRE_CATEGORIA ASC";
		$respuesta=ModeloCategorias::mdlMostrarCategoria($tabla,$item,$valor,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR CIUDADES
	=============================================*/

	static public function ctrEditarCategoria($datos){

		if(isset($datos["categoria"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["categoria"]))
			{
				
				$tabla="categorias";
				$item="NOMBRE_CATEGORIA";
				
				$datos= array("categoria"=>strtoupper($datos["categoria"]),
 							  "token"=>$datos["token"]);

				$respuesta=ModeloCategorias::mdlEditarCategoria($tabla,$datos,$item);
				
					
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

	static public function ctrBorrarCategoria($datos){

		if(isset($datos)){

			$tabla ="categorias";
			$valor = $datos;
			$item = "TOKEN_CATEGORIA";
			
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