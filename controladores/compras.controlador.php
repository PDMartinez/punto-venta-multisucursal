<?php 
/**
 * 
 */
/**
 * 
 */
class ControladorCompras
{
	
	
	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasCompra($item,$valor, $fechaInicial, $fechaFinal,$valor1){

		if($valor1==1){
			$fechaColumna="FECHA_COMPRA";
		}else{
			$fechaColumna="FECHA_ANULADA";
		}

		$respuesta = ModelosCompras::mdlRangoFechasCompra($item,$valor,$fechaInicial, $fechaFinal,$valor1,$fechaColumna);
			return $respuesta;
		
	}


		/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/	

	static public function ctrMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var){

		$respuesta = ModelosCompras::mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3, $valor3,$var);
		return $respuesta;
		
	}



		/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrBuscarCompra($item,$valor, $item1, $valor1,$valor2,$forma){

		

		$respuesta = ModelosCompras::mdlBusquedaClonar($item,$valor, $item1, $valor1,$valor2,$forma);
			return $respuesta;
		
	}

	/*=============================================
	CREAR VENTA
	=============================================*/


	static public function ctrCrearCompra($datos){



		if(isset($datos["txtnrocompra"])){

	
			/*=============================================
			GUARDAR LA Compra
			=============================================*/	
			date_default_timezone_set("America/Asuncion");
			
			$hora_actual=date("H:i");
		 	  $nombres = explode("/",$datos["txtidSucursal"]);
              $CODIGO_SUCURSAL=$nombres[0];
              $item ="COD_SUCURSAL";
              $valor =  $CODIGO_SUCURSAL;

              $tabla="compras";

			
				$nombres = explode("/",$datos["txtUsuario"]);
             	$CODIGO_USUARIO=$nombres[0];

              	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_COMPRA");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

				$ValorMaximo=ModeloVarios::mdlExtraerMaximo("ctaspagar","COD_CUENTA");
				    $tokenCuentas=bin2hex(random_bytes(16));//se genera el token
				    $tokenCuentas=$tokenCuentas.$ValorMaximo["maximo"];

              	$nombres = explode("/",$datos["cmbproveedor"]);
             	$cmbproveedor=$nombres[0];
                	              
				$datos = array("cod_proveedor"=> $cmbproveedor,
			
					"id_usuario"=>$CODIGO_USUARIO,
					"id_sucursal"=>$CODIGO_SUCURSAL,
					"nrocompra"=>$datos["txtnrocompra"],
					"fechacompra"=>$datos["txtFechaCompra"].' '.$hora_actual,
					"preciototal"=>str_replace('.','',$datos["txtpreciototal"]),
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
					"cmbTipoPago"=>$datos["cmbTipoPago"],
					"token_ctaspagar"=>$tokenCuentas,
					"estadoCredito"=>"CREDITO");		
			// echo '<pre>'; print_r($datos); echo '</pre>';
			// return false;
					$respuesta = ModelosCompras::mdlIngresarCompraCab($tabla, $datos);
		
				  if ($respuesta=='ok'){
							$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
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

		static public function ctrAnularCompra($datos){

				if(isset($datos["token_compra"])){

						$respuesta=ModelosCompras::mdlAnularCompraCab("compras",$datos);

						if ($respuesta=='ok'){
							if($datos["estado"]==1){
								$arrResponse=array('status'=>true,'msg'=> 'Registro Anulado Correctamente');
							}else{
								$arrResponse=array('status'=>true,'msg'=> 'Registro recuperado Correctamente');
							}
							
						}else if($respuesta=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion

				

		 	}

		}





}