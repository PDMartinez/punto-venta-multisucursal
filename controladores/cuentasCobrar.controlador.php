<?php 

class ControladorCuentasCobrar{

	/*=============================================
	MOSTRAR CUENTAS A COBRAR
	=============================================*/ 

	static public function ctrMostrarCuentaCobrarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order){

		$respuesta=ModeloCuentasCobrar::MdlMostrarCuentaCobrarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CLIENTES CON CUENTA A COBRAR
	=============================================*/ 

	static public function ctrMostrarClientesCuentaCobrar($item, $valor, $where){

		$respuesta=ModeloCuentasCobrar::mdlMostrarClienteCuentaCobrar($item, $valor, $where);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR LISTADO DE CUENTAS A COBRAR
	=============================================*/ 

	static public function ctrMostrarCuestasCobrarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5){

		$respuesta=ModeloCuentasCobrar::mdlMostrarCuentasCobrarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR CANTIDAD COBRO DE CUENTAS
	=============================================*/

	static public function ctrMostrarCantPagoCuenta($item, $valor){

		$tabla="detctascobrar";
		$order="dcc.COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarCantPagoCuenta($tabla, $item, $valor, $order);
		return $respuesta;

	}


	/*=============================================
	MOSTRAR CUENTAS A COBRAR
	=============================================*/

	static public function ctrMostrarCuentasCobrar($item, $valor){

		$tabla="ctascobrar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarCuentasCobrar($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR CUENTAS A productos clientes
	=============================================*/

	static public function ctrMostrarCuentasCobrarProductos($item, $valor,$order){

		$respuesta=ModeloCuentasCobrar::mdlMostrarCuentasCobrarProductos($item, $valor, $order);
		return $respuesta;

	}

	/*============================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR
	=============================================*/

	static public function ctrMostrarDetCuentasCobrar($item, $valor){

		$tabla="detctascobrar";
		$order="dcc.COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarDetCuentasCobrar($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR NUMERO DE RECIBO
	=============================================*/

	// static public function ctrMostrarNroRecibo($item, $valor){

	// 	$tabla="detctaspagar";
	// 	$order="dcp.COD_CUENTA ASC";

	// 	$respuesta=ModeloCuentasPagar::mdlMostrarNroRecibo($tabla, $item, $valor, $order);
	// 	return $respuesta;

	// }

	/*=============================================
	MOSTRAR DIFERENCIA FECHA
	=============================================*/

	static public function ctrMostrarDiferenciaFecha($item, $valor, $where){

		$tabla="detctascobrar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarDiferenciaFecha($item, $valor, $where, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A COBRAR1
	=============================================*/

	static public function ctrMostrarDetCuentasCobrar1($item, $valor){

		$tabla="detctascobrar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarDetCuentasCobrar1($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR VENTAS
	=============================================*/
	static public function ctrMostrarVentas($item, $valor, $tabla, $order){

		$respuesta=ModeloCuentasCobrar::mdlMostrarVentas($item, $valor, $tabla, $order);
		
		return $respuesta;

	}

	static public function ctrMostrarProducto($item, $valor){

		$tabla="productos";

		$respuesta=ModeloCuentasCobrar::mdlMostrarProductos($tabla, $item, $valor);
		return $respuesta;
	}

	/*============================================================
					CREAR O REGISTAR COBROS
 	==============================================================*/

	static public function ctrGuardarCobro($datos){

			// var_dump($datos);
			// return;

			if(isset($datos["pago"])){

				$listaCuenta=[];

				$listaCuenta = json_decode($datos["pago"], true);

				// var_dump($listaCuenta);
				// return;

				foreach ($listaCuenta as $key => $dato) {

				//validamos los dato nuevamente
					if(! preg_match('/^[-0-9]+$/', $dato["codCuenta"])){

						$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código de la cuenta!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					} 
					 
					if(! preg_match('/^[-0-9]+$/', $dato["codUsuario"])){

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código del usuario!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}  

					if(! preg_match('/^[-0-9\s., ]+$/', $dato["pago"])){

					   	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el cobro!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					} 


					if(! preg_match('/^[-0-9\s., ]+$/', $dato["saldo"])){

					 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el saldo!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}

					if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $dato["fechaPago"])){

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la fecha de pago!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					 }

					if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $dato["estadoCuenta"])) {

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el estado de la cuenta!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}

					if(! preg_match('/^[-0-9]+$/', $dato["nroMovimiento"])) {

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el número de comprobante!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}

					if(! preg_match('/^[()\-0-9. ]+$/', $dato["nroRecibo"])) {

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el número del recibo!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}

					if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $dato["tipoRecibo"])) {

					  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el tipo de recibo!');

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die();
						return;

					}

				}

				$tabla="detctascobrar";

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_DETCUENTAS");
				// var_dump($ValorMaximo["maximo"]);
				// return;
				$token=bin2hex(random_bytes(16));
				$token=$token.$ValorMaximo["maximo"];

				$datos = array("pago"=>$datos["pago"]);

				// $datos = array("codCuenta" => $datos["codCuenta"],
				// 			"codUsuario"=>$datos["codUsuario"],
				// 			"pago"=>$datos["pago"],
				// 		    "fechaVenc" =>$datos["fechaVenc"],
				// 			"saldo"=>$datos["saldo"],
				// 			"fechaPago"=>$datos["fechaPago"],
				// 			"estadoCuenta"=>$datos["estadoCuenta"],
				// 			"nroMovimiento"=>$datos["nroMovimiento"],
				// 			"nroRecibo"=>$datos["nroRecibo"],
				// 			"tipoRecibo"=>$datos["tipoRecibo"],
				// 			"formaPago"=>$datos["formaPago"],
				// 			"agruparAnulado"=>$ValorMaximo["maximo"],
				// 			"tipoVenta"=>$datos["tipoVenta"],
				// 			"token"=>$token,
				// 			"codCaja"=>$datos["codCaja"],
				// 			"codApertura"=>$datos["codApertura"]);

				// var_dump($datos);
				// return;
				    
				$respuesta=ModeloCuentasCobrar::mdlGuardarCobro($tabla, $datos);

				$nombres = explode("/",$respuesta);

				$respuesta = strval($nombres[0]);
				$CODIGO_DETALLE = $nombres[1];
				$CODIGO_CUENTA = $nombres[2];
				
				    
				if ($respuesta =='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente', 'CODIGO_DETALLE'=>$CODIGO_DETALLE, 'CODIGO_CUENTA'=>$CODIGO_CUENTA);

				}else if($respuesta =='exist'){

					$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die(); //para parar la aplicacion

				
			}

	}

	/*=============================================
	MOSTRAR HISTORIAL DE PAGO
	=============================================*/

	static public function ctrMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order){

		$respuesta=ModeloCuentasCobrar::mdlMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order);
		return $respuesta;

	}


	/*=============================================
	MOSTRAR CUENTAS CABECERA
	=============================================*/

	static public function ctrMostrarCuentasCabecera($item, $valor){

		$tabla="ctascobrar";
		$order="cc.COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarCuentasCabecera($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*============================================================
		ANULAR COBRO
 	==============================================================*/

	static public function ctrAnularCobro($datos){

		// var_dump($datos);
		// return;

		if(isset($datos["pago"])){

				//validamos los datos nuevamente
			if(! preg_match('/^[-0-9]+$/', $datos["codCuenta"])){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código de la cuenta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			} 
				 
			if(! preg_match('/^[-0-9]+$/', $datos["codUsuario"])){

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código del usuario!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}  

			if(! preg_match('/^[-0-9\s., ]+$/', $datos["pago"])){

				   	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el pago!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			} 


			if(! preg_match('/^[-0-9\s., ]+$/', $datos["saldo"])){

				 	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el saldo!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if( preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $datos["fechaPago"])){

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en la fecha de pago!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[a-zA-Z0-9ñÑáÁéÉíÍóÓúÚ. ]+$/', $datos["estadoCuenta"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el estado de la cuenta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[-0-9]+$/', $datos["nroMovimiento"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el número de movimiento!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				}

			if(! preg_match('/^[()\-0-9. ]+$/', $datos["nroRecibo"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el número del recibo!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			if(! preg_match('/^[()\-0-9a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s., ]+$/', $datos["tipoRecibo"])) {

				  	$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el tipo de recibo!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

			}

			$tabla="detctascobrar";

			$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_DETCUENTAS");
			$token=bin2hex(random_bytes(16));//se genera el token
			$token=$token.$ValorMaximo["maximo"];

			$datos = array("codCuenta" => $datos["codCuenta"],
							"codUsuario"=>$datos["codUsuario"],
							"pago"=>$datos["pago"],
						    "fechaVenc" =>$datos["fechaVenc"],
							"saldo"=>$datos["saldo"],
							"fechaPago"=>$datos["fechaPago"],
							"estadoCuenta"=>$datos["estadoCuenta"],
							"formaPago"=>$datos["formaPago"],
							"nroMovimiento"=>$datos["nroMovimiento"],
							"nroRecibo"=>$datos["nroRecibo"],
							"tipoRecibo"=>$datos["tipoRecibo"],
							"agruparAnulado"=>$datos["agruparAnulado"],
							"detMovimiento"=>$datos["detMovimiento"],
							"tokenCuentaDet"=>$datos["tokenCuentaDet"],
							"token"=>$token,
							"codCaja"=>$datos["codCaja"],
							"codApertura"=>$datos["codApertura"],);
				    
			$respuesta=ModeloCuentasCobrar::mdlAnularCobro($tabla, $datos);
				    
			if ($respuesta =='ok'){

				$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

			}else if($respuesta =='exist'){

				$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

			}else{

				$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');

			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

			die(); //para parar la aplicacion

				
		}

	}

	/*============================================================
					MODIFICAR COMENTARIO
 	==============================================================*/

	static public function ctrModificarComentario($item1, $valor1, $item2, $valor2){

			if(isset($valor1)){

				//validamos los datos nuevamente
				if(! preg_match('/^[-0-9]+$/', $valor1)){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código de la cuenta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 
				    
				$respuesta=ModeloCuentasCobrar::mdlModificarComentario($item1, $valor1, $item2, $valor2);
				    
				if ($respuesta =='ok'){

					$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');

				}else if($respuesta =='exist'){

					$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');

				}else{

					$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');

				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON

				die(); //para parar la aplicacion

				
			}

	}

	/*=============================================
	MOSTRAR CABECERA TICKET
	=============================================*/

	static public function ctrMostrarCabeceraTicket($item, $valor){

		// $tabla="ctascobrar";
		// $order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarCabeceraTicket($item, $valor);
		return $respuesta;

	}


	/*=============================================
	MOSTRAR DETALLES DE TICKET
	=============================================*/

	static public function ctrMostrarDetalleTicket($item, $valor, $valor1){

		// $tabla="ctascobrar";
		// $order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasCobrar::mdlMostrarDetalleTicket($item, $valor, $valor1);
		return $respuesta;

	}



}
