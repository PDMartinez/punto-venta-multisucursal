<?php 

 class ControladorSubCategorias
 {
	/*=======================================
	 CREAR SUB CATEGORIAS A GUARDAR
	 =====================================*/
	static public function ctrCrearSubCategoria($datos)
	{
		if(isset($datos))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos))
			{
				date_default_timezone_set("America/Asuncion");
				$fecha = date('Y-m-d');
				$hora = date('H:i:s');

				$fechaActual = $fecha.' '.$hora;

				$tabla="sub_categorias";
				$item="NOMBRE_SUBCATEGORIA";
							
				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_SUBCATEGORIA");
				
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

 				$datos= array("subcategoria"=>strtoupper($datos),
 							"token"=>$token,
 							"fecha_registro"=>$fechaActual);

				$respuesta=ModeloSubCategorias::mdlIngresarSubCategoria($tabla,$datos,$item);
				
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
	 MOSTRAR SUB CATEGORIAS
	 =====================================*/
	static public function ctrMostrarSubCategoria($item,$valor)
	{
		$tabla="sub_categorias";
		$order="NOMBRE_SUBCATEGORIA ASC";
		$respuesta=ModeloSubCategorias::mdlMostrarSubCategoria($tabla,$item,$valor,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR SUB CATEGORIAS
	=============================================*/

	static public function ctrEditarSubCategoria($datos){

		if(isset($datos["subcategoria"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["subcategoria"]))
			{
				
				$tabla="sub_categorias";
				$item="NOMBRE_SUBCATEGORIA";
				
				$datos= array("subcategoria"=>strtoupper($datos["subcategoria"]),
 							  "token"=>$datos["token"]);

				$respuesta=ModeloSubCategorias::mdlEditarSubCategoria($tabla,$datos,$item);
				
					
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
	BORRAR SUB CATEGORIAS
	=============================================*/

	static public function ctrBorrarSubCategoria($datos){

		if(isset($datos)){

			$tabla ="sub_categorias";
			$valor = $datos;
			$item = "TOKEN_SUBCATEGORIA";
			
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