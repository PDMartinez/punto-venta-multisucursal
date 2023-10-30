<?php 
/**
 * 
 */
/**
 * 
 */
class ControladorVentas
{
	
	
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVenta($item,$valor, $fechaInicial, $fechaFinal,$valor1){

		if($valor1==1){
			$fechaColumna="FECHA_VENTA";
		}else{
			$fechaColumna="FECHA_ANULADA";
		}

		$respuesta = ModelosVentas::mdlRangoFechasVenta($item,$valor,$fechaInicial, $fechaFinal,$valor1,$fechaColumna);
			return $respuesta;
		
	}

	/*============================================================
					MOSTRAR CAJAS
 		==============================================================*/
		static public function ctrMostrarCaja($item, $valor,$select){

			$tabla="cajas";
			
			$respuesta=ModelosVentas::mdlConsultarCombos($tabla, $item, $valor,$select);
			return $respuesta;
		}


	/*=============================================
	TRAER PREVENTA
	=============================================*/	

	static public function ctrConsultarPreVenta($item,$valor,$item1,$valor1,$item2,$valor2,$order){

		
		$respuesta = ModelosVentas::mdlPreVenta($item,$valor,$item1,$valor1,$item2,$valor2,$order);
			return $respuesta;
		
	}


		/*=============================================
	MOSTRAR COMBOS
	=============================================*/	

	static public function ctrMostrarCombos($tabla,$item, $valor,$select){

		$respuesta = ModelosVentas::mdlConsultarCombos($tabla,$item, $valor,$select);
		return $respuesta;
		
	}


	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/	


	static public function ctrMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var){

		$respuesta = ModelosVentas::mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var);
		return $respuesta;
		
	}
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/	


	static public function ctrMostrarProductoCodigoBarra($item, $valor,$item1, $valor1,$item2,$valor2){

		$respuesta = ModelosVentas::mdlMostrarProductoCodigoBarra($item, $valor,$item1, $valor1,$item2,$valor2);
		return $respuesta;
		
	}

		/*=============================================
	MOSTRAR CANAL DE PRODUCTOS PARA EL DESCUENTO
	=============================================*/	


	static public function ctrMostrarCanalProducto($tabla,$tabla1,$seleccionar, $item, $valor,$item1, $valor1,$order){

		$respuesta = ModelosVentas::mdlMostrarCanalProducto($tabla,$tabla1,$seleccionar, $item, $valor,$item1, $valor1,$order);
		return $respuesta;
		
	}




		/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrBuscarVenta($item,$valor, $item1, $valor1,$valor2,$forma){

		

		$respuesta = ModelosVentas::mdlBusquedaClonar($item,$valor, $item1, $valor1,$valor2,$forma);
			return $respuesta;
		
	}

	/*=============================================
	CREAR VENTA
	=============================================*/


	static public function ctrCrearVenta($datos){



		if(isset($datos["txtnroVenta"])){


			
			/*=============================================
			GUARDAR LA Compra
			=============================================*/	
			date_default_timezone_set("America/Asuncion");
			
			$hora_actual=date("H:i");
	 	  	$nombres = explode("/",$datos["txtidSucursal"]);
	     	$CODIGO_SUCURSAL=$nombres[0];
	      	$item ="COD_SUCURSAL";
	      	$valor =  $CODIGO_SUCURSAL;

          	$tabla="ventas";

		
			$nombres = explode("/",$datos["txtUsuario"]);
         	$CODIGO_USUARIO=$nombres[0];

          	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_COMPRA");
			$token=bin2hex(random_bytes(16));//se genera el token
			$token=$token.$ValorMaximo["maximo"];

			$ValorMaximo=ModeloVarios::mdlExtraerMaximo("ctaspagar","COD_CUENTA");
		    $tokenCuentas=bin2hex(random_bytes(16));//se genera el token
		    $tokenCuentas=$tokenCuentas.$ValorMaximo["maximo"];

		    $ValorMaximo=ModeloVarios::mdlExtraerMaximo("detventas","COD_DETVENTA");
		    $token_detalles=bin2hex(random_bytes(16));//se genera el token
		    $token_detalle=$token_detalles.$ValorMaximo["maximo"];


          	$nombres = explode("/",$datos["cmbClientes"]);
         	$cmbclientes=$nombres[0];

         	$cajas = explode("/",$datos["txtidCaja"]);
         	$idcaja=$cajas[0];
                	              
			$datos = array("cod_clientes"=> $cmbclientes,
			
					"id_usuario"=>$CODIGO_USUARIO,
					"id_sucursal"=>$CODIGO_SUCURSAL,
					"txtnroVenta"=>$datos["txtnroVenta"],
					"txtFechaVenta"=>$datos["txtFechaVenta"].' '.$hora_actual,
					"formapago"=>$datos["cmbFormapago"],
					"tipopago"=>$datos["cmbTipoPago"],
					"metodopago"=>$datos["cmbMetodopago"],
					"token"=>$token,
					"cmbTipoMovimiento"=>$datos["cmbTipoMovimiento"],
					"listaProducto"=>$datos["txtproductos"],
					"estado"=>1,
					"cantidad_cuota"=>$datos["txtcantidadCuota"],
					"monto_cuota"=> str_replace('.','',$datos["txtMontoCuota"]),
					"preciototal"=>str_replace('.','',$datos["txtpreciototal"]),
					"fecha_vencimiento"=>$datos["txtFechaVencimiento"],
					"token_ctaspagar"=>$tokenCuentas,
					"estadoCredito"=>"CREDITO",
					"txtidApertura"=>$datos["txtidApertura"],
					"idCaja"=>$idcaja,
					"token_detalle"=>$token_detalle,
					"avisoStock"=>$datos["avisoStock"],
					"txtpedidos"=>$datos["txtpedidos"],
					"txtTotal"=>$datos["txtTotal"]);		
			// echo '<pre>'; print_r($datos); echo '</pre>';
			// return false;

				
					
			//echo '<pre>'; print_r($listaProductos); echo '</pre>';

				$controlstock = ModelosVentas::mdlControlarStock($datos);
				// echo '<pre>'; print_r($controlstock); echo '</pre>';
				// return;
		
				  if ($controlstock!=null){

					$arrResponse=array('status'=>false,'msg'=> 'El producto: '.$controlstock. ' no tiene un stock requerido verifique.');
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion
					
					}
						

					$respuesta = ModelosVentas::mdlIngresarVentaCab($tabla, $datos);

					//OBTENEMOS EL ULTIMO ID GENERADO CON LA VENTA Y RETORNAMOS EN EL JS

					$nombres = explode("/",$respuesta);
					$CODIGO_VENTA = $nombres[1];
					$respuesta = strval($nombres[0]);

					// var_dump($CODIGO_VENTA);
					// var_dump($respuesta);
		
				  if ($respuesta=='ok'){
							$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente', 'CODIGO_VENTA'=>$CODIGO_VENTA);
						}else if($respuesta=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion

		
	}

}

	/*=============================================
	ANULAR VENTAS
	=============================================*/

	static public function ctrAnularVenta($datos){

				if(isset($datos["token_venta"])){
					

						$respuesta=ModelosVentas::mdlAnularVentaCab("ventas",$datos);
					
						if ($respuesta=='ok'){
							if($datos["estado"]==1){
								$arrResponse=array('status'=>true,'msg'=> 'Registro Anulado Correctamente');
							}else{
								$arrResponse=array('status'=>true,'msg'=> 'Registro recuperado Correctamente');
							}
							
						}else if($respuesta=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible anular el datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion

				

		 	}

	}

	/*=============================================
	MOSTRAR CABECERA TICKET
	=============================================*/	

	static public function ctrMostrarCabeceraTicket($item, $valor){

		$respuesta = ModelosVentas::mdlMostrarCabeceraTicket($item, $valor);
		return $respuesta;
		
	}

	/*=============================================
	MOSTRAR DETALLE TICKET
	=============================================*/	

	static public function ctrMostrarDetalleTicket($item, $valor){

		$respuesta = ModelosVentas::mdlMostrarDetalleTicket($item, $valor);
		return $respuesta;
		
	}


	/*=============================================
	MOSTRAR METODO PAGO X ID
	=============================================*/	

	static public function ctrMostrarMetodoPagoId($item, $valor){

		$respuesta = ModelosVentas::mdlMostrarMetodoPagoId($item, $valor);
		return $respuesta;
		
	}

}