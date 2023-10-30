<?php 

 class ControladorPerfiles
 {
	/*=======================================
	 CREAR CATEGORIA A GUARDAR
	 =====================================*/
	static public function ctrCrearPerfil($datos)
	{
		if(isset($datos["perfil"]))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ]+$/', $datos["perfil"])||
			  preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["descripcion"]))
			{
				
				$tabla="perfiles";
				$item="SUPER_PERFIL";

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_PERFIL");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

 				$datos= array("perfil"=>strtoupper($datos["perfil"]),
 							  "descripcion"=>strtoupper($datos["descripcion"]),
 				              "activo"=>$datos["activo"],
 				              "estado"=>$datos["estado"],
			    			  "token"=>$token,
			    			"principal"=>$datos["principal"]);
 				
				$respuesta=ModeloPerfiles::mdlIngresarPerfil($tabla,$datos,$item);
				
				// var_dump($respuesta);
				if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
					}else if($respuesta=='principal'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ningun super usuario, por favor seleccione uno');
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
	 CREAR CATEGORIA A GUARDAR
	 =====================================*/
	static public function ctrMostrarPerfil($item,$valor,$var)
	{
		$tabla="perfiles";
		$order="NOMBRE_PERFIL ASC";
		$respuesta=ModeloPerfiles::mdlMostrarPerfil($tabla,$item,$valor,$var,$order);
		return $respuesta;


	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function ctrEditarPerfil($datos){

		if(isset($datos["perfil"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["perfil"])||
			  preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["descripcion"]))
			{
				
				$tabla="perfiles";
				$item="SUPER_PERFIL";
				$datos= array("perfil"=>strtoupper($datos["perfil"]),
 							  "descripcion"=>strtoupper($datos["descripcion"]),
 				              "activo"=>$datos["activo"],
 				              "estado"=>$datos["estado"],
			    			  "token"=>$datos["idPerfil"],
			    			"principal"=>$datos["principal"]);

				$respuesta=ModeloPerfiles::mdlEditarPerfil($tabla,$datos,$item);
				
					
					if ($respuesta=='ok'){
						$arrResponse=array('status'=>true,'msg'=> 'Datos Actualizado correctamente');
					}else if($respuesta=='principal'){
						$arrResponse=array('status'=>false,'msg'=> '¡Atención! No hay ningun super usuario, por favor seleccione uno');
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

	static public function ctrBorrarPerfil($datos){

		if(isset($datos)){

			$tabla ="perfiles";
			$valor = $datos;
			$item = "TOKEN_PERFIL";
			
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