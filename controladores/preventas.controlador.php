<?php 
/**
 * 
 */
/**
 * 
 */
class ControladorPreVentas
{
	
	
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVenta($item,$valor, $fechaInicial, $fechaFinal,$valor1,$valor2){

		if($valor1==1){
			$fechaColumna="FECHA_PEDIDO";
		}else{
			$fechaColumna="FECHA_ANULADA";
		}

		$respuesta = ModelosPreVentas::mdlRangoFechasVenta($item,$valor,$fechaInicial, $fechaFinal,$valor1,$valor2,$fechaColumna);
			return $respuesta;
		
	}


		/*=============================================
	MOSTRAR COMBOS
	=============================================*/	

	static public function ctrMostrarCombos($tabla,$item, $valor,$select){

		$respuesta = ModelosPreVentas::mdlConsultarCombos($tabla,$item, $valor,$select);
		return $respuesta;
		
	}


	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/	


	static public function ctrMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var){

		$respuesta = ModelosPreVentas::mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var);
		return $respuesta;
		
	}



		/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrBuscarVenta($item,$valor, $item1, $valor1,$valor2){

		

		$respuesta = ModelosPreVentas::mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2);
		return $respuesta;
		
	}

	/*=============================================
	CREAR VENTA
	=============================================*/


	static public function ctrCrearVenta($datos){



		if(isset($datos["txtUsuario"])){

			/*=============================================
			GUARDAR LA Compra
			=============================================*/	
			
			date_default_timezone_set("America/Asuncion");
			
			$hora_actual=date("H:i");
		 	  $nombres = explode("/",$datos["txtidSucursal"]);
              $CODIGO_SUCURSAL=$nombres[0];
              $item ="COD_SUCURSAL";
              $valor =  $CODIGO_SUCURSAL;

              $tabla="pedidos";

			
				$nombres = explode("/",$datos["txtUsuario"]);
             	$CODIGO_USUARIO=$nombres[0];

              	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_PEDIDO");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

			  
              	$nombres = explode("/",$datos["cmbClientes"]);
             	$cmbclientes=$nombres[0];

                             	              
				$datos = array("cod_clientes"=> $cmbclientes,
					"id_usuario"=>$CODIGO_USUARIO,
					"id_sucursal"=>$CODIGO_SUCURSAL,
					"txtFechaPedido"=>$datos["txtFechaVenta"].' '.$hora_actual,
					"token"=>$token,
					"listaProducto"=>$datos["txtproductos"],
					"estado"=>$datos["tipomovimiento"]);		
			// echo '<pre>'; print_r($datos); echo '</pre>';
			// return false;
					$respuesta = ModelosPreVentas::mdlIngresarVentaCab($tabla, $datos);

					//OBTENEMOS EL ULTIMO ID GENERADO CON LA VENTA Y RETORNAMOS EN EL JS

					$nombres = explode("/",$respuesta);
					$CODIGO_VENTA = $nombres[1];
					$respuesta = strval($nombres[0]);
		
				  if ($respuesta=='ok'){
							$arrResponse=array('status'=>true,'msg'=> 'Datos procesados Correctamente', 'CODIGO_VENTA'=>$CODIGO_VENTA);
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

				if(isset($datos["token_pedido"])){
					

						$respuesta=ModelosPreVentas::mdlAnularVentaCab("pedidos",$datos);
					
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

		$respuesta = ModelosPreVentas::mdlMostrarCabeceraTicket($item, $valor);
		return $respuesta;
		
	}

	/*=============================================
	MOSTRAR DETALLE TICKET
	=============================================*/	

	static public function ctrMostrarDetalleTicket($item, $valor){

		$respuesta = ModelosPreVentas::mdlMostrarDetalleTicket($item, $valor);
		return $respuesta;
		
	}


}