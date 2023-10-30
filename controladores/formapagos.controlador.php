<?php 

 class ControladorFormaPagos
 {
	/*=======================================
	 CREAR CIUDADES A GUARDAR
	 =====================================*/
	static public function ctrCrearFormaPago($datos)
	{
		if(isset($datos))
		{

			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["formapagos"]))
			{
				
				$tabla="forma_pagos";
				$item="DESCRIPCION_FORMA";
							
				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_FORMAPAGO");
				    $token=bin2hex(random_bytes(16));//se genera el token
				    $token=$token.$ValorMaximo["maximo"];
				    
 				$datos= array("formapagos"=>strtoupper($datos["formapagos"]),
 								"activoefectivo"=> $datos["activoefectivo"],
 							  "token"=>$token);

				$respuesta=ModeloFormaPagos::mdlIngresarFormaPago($tabla,$datos,$item);
				
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
	static public function ctrMostrarFormapago($item,$valor,$item1,$valor1)
	{
		$tabla="forma_pagos";
		$order="DESCRIPCION_FORMA ASC";
		$respuesta=ModeloFormaPagos::mdlMostrarFormapago($tabla,$item,$valor,$item1,$valor1,$order);
		return $respuesta;


	}



	/*=============================================
	EDITAR CIUDADES
	=============================================*/

	static public function ctrEditarFormaPago($datos){

		if(isset($datos["formapagos"]))
		{

		
			if(preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ ]+$/', $datos["formapagos"]))
			{
				
				$tabla="forma_pagos";
				$item="DESCRIPCION_FORMA";
				
				$datos= array("formapagos"=>strtoupper($datos["formapagos"]),
								"activoefectivo"=>$datos["activoefectivo"],
							  "token"=>$datos["token"]);

				$respuesta=ModeloFormaPagos::mdlEditarFormapago($tabla,$datos,$item);
				
					
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

	static public function ctrBorrarFormapago($datos){

		if(isset($datos)){

			$tabla ="forma_pagos";
			$valor = $datos;
			$item = "TOKEN_FORMAPAGO";
			
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



	/*============================================================
					ANULAR FORMAS DE PAGOS
 		==============================================================*/

		static public function ctrAnularFormapagos($item,$valor,$item1,$valor1){



				//echo'<script>alert("'.$_POST["idEliminar"].'");</script>';

				$tabla="forma_pagos";
				
				$respuesta = ModeloVarios::mdlActualizarVario($tabla, $item,$valor,$item1,$valor1);

				if($valor==0){
					if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Anulado Correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible Anular el dato, el mismo está siendo usado.');

					}
				}else{
					if ($respuesta=='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos recuperado Correctamente');

					}else{

						$arrResponse=array('status'=>false,'msg'=> 'No es posible recuperar el dato, el mismo está siendo usado.');

					}
				}
				
				

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
				die();
			
		}








 }