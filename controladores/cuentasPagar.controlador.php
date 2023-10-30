<?php 

class ControladorCuentasPagar{

	/*=============================================
	MOSTRAR CUENTAS A PAGAR
	=============================================*/ 

	static public function ctrMostrarCuentaPagarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order){

		$respuesta=ModeloCuentasPagar::MdlMostrarCuentaPagarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR PROVEEDORES CON CUENTA A PAGAR
	=============================================*/ 

	static public function ctrMostrarProveedorCuentaPagar($item, $valor, $where){

		// var_dump($item);

		$respuesta=ModeloCuentasPagar::mdlMostrarProveedorCuentaPagar($item, $valor, $where);
		return $respuesta;
	}

	/*=============================================
	MOSTRAR PROVEEDORES CON CUENTA A PAGAR
	=============================================*/ 

	static public function ctrMostrarCuestasPagarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5){

		// var_dump($item);

		$respuesta=ModeloCuentasPagar::mdlMostrarCuentasPagarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5);
		return $respuesta;
	}


	/*=============================================
	MOSTRAR CUENTAS A PAGAR
	=============================================*/

	static public function ctrMostrarCuentasPagar($item, $valor){

		$tabla="ctaspagar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarCuentasPagar($tabla, $item, $valor, $order);
		return $respuesta;

	}


/*=============================================
	MOSTRAR CUENTAS A PAGAR CON PRODUCTOS
	=============================================*/

	static public function ctrMostrarCuentasPagarProductos($item, $valor,$order){

		$respuesta=ModeloCuentasPagar::mdlMostrarCuentasPagarProductos($item, $valor, $order);
		return $respuesta;

	}
	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR
	=============================================*/

	static public function ctrMostrarDetCuentasPagar($item, $valor){

		$tabla="detctaspagar";
		$order="dcp.COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarDetCuentasPagar($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR NUMERO DE RECIBO
	=============================================*/

	static public function ctrMostrarNroRecibo($item, $valor){

		$tabla="detctaspagar";
		$order="dcp.COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarNroRecibo($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR DIFERENCIA FECHA
	=============================================*/

	static public function ctrMostrarDiferenciaFecha($item, $valor, $where){

		// $tabla="detctaspagar";
		// $order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarDiferenciaFecha($item, $valor, $where);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR CANTIDAD PAGO DE CUENTAS
	=============================================*/

	static public function ctrMostrarCantPagoCuenta($item, $valor){

		$tabla="detctaspagar";
		$order="dcp.COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarCantPagoCuenta($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR DETALLES DE CUENTAS A PAGAR1
	=============================================*/

	static public function ctrMostrarDetCuentasPagar1($item, $valor){

		$tabla="detctaspagar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarDetCuentasPagar1($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR COMPRAS
	=============================================*/
	static public function ctrMostrarCompras($item, $valor, $tabla, $order){

		$respuesta=ModeloCuentasPagar::mdlMostrarCompras($item, $valor, $tabla, $order);
		
		return $respuesta;

	}

	static public function ctrMostrarProducto($item, $valor){

		$tabla="productos";

		$respuesta=ModeloCuentasPagar::mdlMostrarProductos($tabla, $item, $valor);
		return $respuesta;
	}

	/*============================================================
					CREAR O REGISTAR PAGOS
 	==============================================================*/

	static public function ctrCrearPago($datos){

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

				$tabla="detctaspagar";

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_DETCUENTAS");
				// var_dump($ValorMaximo["maximo"]);
				// return;
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

				$datos = array("codCuenta" => $datos["codCuenta"],
							"codUsuario"=>$datos["codUsuario"],
							"pago"=>$datos["pago"],
						    "fechaVenc" =>$datos["fechaVenc"],
							"saldo"=>$datos["saldo"],
							"fechaPago"=>$datos["fechaPago"],
							"estadoCuenta"=>$datos["estadoCuenta"],
							"nroMovimiento"=>$datos["nroMovimiento"],
							"nroRecibo"=>$datos["nroRecibo"],
							"tipoRecibo"=>$datos["tipoRecibo"],
							"formaPago"=>$datos["formaPago"],
							"agruparAnulado"=>$ValorMaximo["maximo"],
							"tipoVenta"=>$datos["tipoVenta"],
							"token"=>$token);

				// var_dump($datos);
				// return;
				    
				$respuesta=ModeloCuentasPagar::mdlIngresarPago($tabla, $datos);
				    
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
	MOSTRAR HISTORIAL DE PAGO
	=============================================*/

	static public function ctrMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order){

		$respuesta=ModeloCuentasPagar::mdlMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order);
		return $respuesta;

	}

	/*=============================================
	MOSTRAR LISTADO DE CUENTAS PAGADAS
	=============================================*/

	// static public function ctrMostrarListadoCuentas($item1, $valor1, $valor2, $tabla1, $order){

	// 	$respuesta=ModeloCuentasPagar::mdlMostrarListadoCuentas($item1, $valor1, $valor2, $tabla1, $order);
	// 	return $respuesta;

	// }

	/*=============================================
	MOSTRAR CUENTAS CABECERA
	=============================================*/

	static public function ctrMostrarCuentasCabecera($item, $valor){

		$tabla="ctaspagar";
		$order="COD_CUENTA ASC";

		$respuesta=ModeloCuentasPagar::mdlMostrarCuentasCabecera($tabla, $item, $valor, $order);
		return $respuesta;

	}

	/*============================================================
		ANULAR PAGO
 	==============================================================*/

	static public function ctrAnularPago($datos){

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

			$tabla="detctaspagar";

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
							"token"=>$token);
				    
			$respuesta=ModeloCuentasPagar::mdlAnularPago($tabla, $datos);
				    
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
					CREAR O REGISTAR PAGOS
 	==============================================================*/

	static public function ctrModificarComentario($item1, $valor1, $item2, $valor2){

			// var_dump($datos);
			// return;

			if(isset($valor1)){

				//validamos los datos nuevamente
				if(! preg_match('/^[-0-9]+$/', $valor1)){

					$arrResponse=array('status'=>false,'msg'=> '¡No se permiten caracteres especiales en el código de la cuenta!');

					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
					die();
					return;

				} 

				// var_dump($datos);
				// return;
				    
				$respuesta=ModeloCuentasPagar::mdlModificarComentario($item1, $valor1, $item2, $valor2);
				    
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



}
