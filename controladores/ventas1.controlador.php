<?php 
/**
 * 
 */
class ControladorCompras
{
	
	static public function ctrMostrarVentas($item,$valor,$valor1)
	{
		# code...
		$tabla="ventas";
		$respuesta=ModelosVentas::mdlMostrarVentas($tabla,$item,$valor,$valor1);
		
		return $respuesta;

	}

	static public function ctrMostrarVentasDetalle($item,$valor)
	{
		# code...
		$tabla="detventas";
		$respuesta=ModelosVentas::mdlMostrarVentasdet($tabla,$item,$valor);
		return $respuesta;

	}


	/*=============================================
	FILTRAR HABITACIONES
	=============================================*/
	static public function 	ctrFiltarHabitaciones($item,$valor)
	{
		
		$tabla="ventas";
	
		$respuesta=ModeloHabitaciones::mdlFiltrarHabitaciones($tabla,$item,$valor);
		return $respuesta;
	}

	static public function ctrMostrarDetVentas($fechaInicial, $fechaFinal,$valor1)
	{
		# code...
		$tabla="detventas";
		$tabla1="ventas";
		$respuesta=ModelosVentas::mdlRangoFechasVentasDet($tabla,$tabla1,$fechaInicial, $fechaFinal,$valor1);
		return $respuesta;

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasRemision($fechaInicial, $fechaFinal,$valor1){

		$tabla = "remision";
		$tabla1 = "det_remision";
		$tabla2 = "productos";
		$tabla3 = "sucursales";
		$tabla4 = "usuarios";

		$respuesta = ModelosRemisiones::mdlRangoFechasRemision($tabla,$tabla1,$tabla2,$tabla3,$tabla4,$fechaInicial, $fechaFinal,$valor1);
			return $respuesta;
		
	}

	/*=============================================
	CREAR VENTA
	=============================================*/

	static public function ctrCrearCompra($datos){



		if(isset($datos["txtnrocompra"])){

	$listaProducto=$datos["txtproductos"];

	/*=============================================
	GUARDAR LA REMISION
	=============================================*/	
	date_default_timezone_set('America/Asuncion');
		 	  	$nombres = explode("/",$datos["txtidSucursal"]);
              	$CODIGO_SUCURSAL=$nombres[0];        
                          				
				$nombres = explode("/",$datos["txtUsuario"]);
             	$CODIGO_USUARIO=$nombres[0];
             	$tabla="ventas";
              	$ValorMaximo=ModeloVarios::mdlExtraerMaximo($tabla,"COD_FACTURA");
				$token=bin2hex(random_bytes(16));//se genera el token
				$token=$token.$ValorMaximo["maximo"];

              	$nombres = explode("/",$datos["cmbproveedor"]);
             	$cmbproveedor=$nombres[0];

             
				$hora = date('H:i:s');
				$fecha = explode("/",$datos["txtFechaCompra"]);
				             	
				$nuevaFecha=$fecha[2].'/'.$fecha[1].'/'.$fecha[0].' '.$hora;            	    
				
				$datos1 = array("txtnrocompra"=>$datos["txtnrocompra"], 
				"id_usuario"=>$CODIGO_USUARIO,
				"id_sucursal"=>$CODIGO_SUCURSAL,
				"cmbproveedor"=> $cmbproveedor,
				"preciototal"=>str_replace('.','',$datos["txtpreciototal"])
						   ,
				"txtnrorecibo"=>$datos["txtnrorecibo"],
				"cmbFormapago"=>$datos["cmbFormapago"], 
				"cmbTipoMovimiento"=>$datos["cmbTipoMovimiento"], 
				"cmbMetodopago"=>$datos["cmbMetodopago"], 
				"txtFechaCompra"=>$nuevaFecha, 
				"token"=>$token,
				"estado"=>1);

		
				
			$respuesta = ModelosCompras::mdlIngresarCompraCab($tabla, $datos1);
		
			if($respuesta>0){

				// //ACTUALIZAR EL NUMERO DE REMISION

				// $actualizarRemision=ModeloVarios::mdlActualizarVario("sucursales", "NROREMISION",$numeroVerifcador,"COD_SUCURSAL",$CODIGO_SUCURSAL);

			/*=============================================
			recorrer el producto y cargar en un array e insertar
			=============================================*/
		
		$listaProductos = json_decode($listaProducto, true);
			$cod_Compra=$respuesta;
			
			foreach ($listaProductos as $key => $value) {
				$nombres = explode("/",$value["id"]);
             	$idProducto=$nombres[0];
 				$stockAnterior_D =  ControladorProductos::ctrMostrarProducto("COD_PRODUCTO", $idProducto,"EST_ARTICULOS",1,"COD_SUCURSAL",$CODIGO_SUCURSAL);
 				 			
 			
			$datos2 = array("id_producto"=>$idProducto,
						"cantidad"=>str_replace(',','.',$value["cantidad"]),
						"precio_unitario"=>str_replace('.','',$value["precio"]),
						"codigo"=>$cod_Compra,
						"neto"=>str_replace('.','',$value["total"]),
						"stock_A"=>str_replace(',','.',$stockAnterior_D["EXISTENCIA"]),
						"descuento"=>str_replace('.','',$value["descuento"]));
			$tabla = "det_compras";
			$detCompras = ModelosCompras::mdlIngresarCompraDet($tabla, $datos2);

			if($detCompras=="ok"){
				
				$StockSuma=$stockAnterior_D["EXISTENCIA"]+ str_replace(',','.',$value["cantidad"]);
				$actualizarStockhasta=ModelosProductos::mdlActualizar("stocks", "EXISTENCIA",$StockSuma,"COD_PRODUCTO",$idProducto,"COD_SUCURSAL",$CODIGO_SUCURSAL);

				}

			}



			if($datos["cmbFormapago"]=="Credito"){
				$fecha = explode("/",$datos["txtFechaVencimiento"]);           	
				$Fechavencimiento=$fecha[2].'/'.$fecha[1].'/'.$fecha[0].' '.$hora; 
			$datos3 = array("cod_compra"=>$cod_Compra, 
				"fecha"=>$nuevaFecha,
				"cantidad_cuota"=>$datos["txtcantidadCuota"],
				"monto_cuota"=> str_replace('.','',$datos["txtMontoCuota"]),
				"preciototal"=>str_replace('.','',$datos["txtpreciototal"])
						   ,
				"fecha_vencimiento"=>$Fechavencimiento,
				"cmbTipoPago"=>$datos["cmbTipoPago"], 
				"estado"=>"Credito");
			$tabla="ctaspagar";
		
			$respuesta = ModelosCompras::mdlIngresarCtaspagar($tabla, $datos3);

			}

				  if ($detCompras=='ok'){
							$arrResponse=array('status'=>true,'msg'=> 'Datos Guardado Correctamente');
						}else if($detCompras=='exist'){
							$arrResponse=array('status'=>false,'msg'=> '¡Atención! El dato ya existe.');
						}else{
							$arrResponse=array('status'=>false,'msg'=> 'No es posible almacenar los datos.');
						}

						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); // convertimos en JSON
						die(); //para parar la aplicacion


		}

		
	}

}

/*=============================================
	ANULAR VENTAS
	=============================================*/

	static public function ctrEliminarVenta(){

		if(isset($_GET["idVenta"])){

		
			$respuesta=ModelosVentas::mdlMostrarVentasdet("detventas","COD_VENTA",$_GET["idVenta"]);

		
			foreach ($respuesta as $key => $value) {
 				
			// AGREGAR CONTROL DE STOCK 
			
  				$item = "COD_PRODUCTO";
        		$valor = $value["COD_PRODUCTO"];
        		$Activo=1;
        		$respuesta = ControladorProductos::ctrMostrarProductos($item, $valor,$Activo);


			
			
				$stock=0;
				$estadoProducto="";

				//var_dump($datos);
				if($_GET["estado"]=='EMITIDO'){
				$resta=$respuesta["EXISTENCIA"]+$value["CANTIDAD"];
				$stock=$value["CANTIDAD"]*-1;
				$estadoProducto="ANULADO VENTA";
				}else{
				$resta=$respuesta["EXISTENCIA"]-$value["CANTIDAD"];
				$stock=$value["CANTIDAD"];
				$estadoProducto="EMITIDO VENTA";
				}

				$tabla = "ficha_stock";
				$datos = array("cod_producto" => $value["COD_PRODUCTO"],
							"cod_usuario" => $_GET["usuario"],
							"stock" => $stock,
							"stockAnterior" =>$respuesta["EXISTENCIA"],
							"estado" => $estadoProducto);
				$respuesta = ModeloProductos::mdlIngresarFichaStock($tabla, $datos);

				
				$tabla = "productos";

			    $item1 = "EXISTENCIA";
			    $valor1 = $resta;

			    $item2 = "COD_PRODUCTO";
			    $valor2 = $value["COD_PRODUCTO"];

			    $respuesta =  ModeloVarios::mdlActualizarVario($tabla,$item1, $valor1,$item2, $valor2);


			}
			

			$tabla ="ventas";
			$valor2 = $_GET["idVenta"];
			$item2 = "COD_VENTA";
			$item1 = "ESTADO_VENTAS";

			$fechaAnulada = date('d-m-Y');


			if($_GET["estado"]=='EMITIDO'){
				$valor1 = "ANULADO";
				$valor3 = $_GET["usuario"];
				$item3 = "USUARIO_ANULADO";

			}else{
				$valor1 = "EMITIDO";
				$valor3 = $_GET["usuario"];
				$item3 = "USUARIO_ANULADO";
			}
		


			$respuesta = ModelosVentas::mdlActualizarVenta($tabla,$item1, $valor1,$item2,$valor2,$item3,$valor3);

			if($respuesta == "ok"){
				if($_GET["estado"]=='EMITIDO'){
				echo'<script>

				swal({
					  type: "success",
					  title: "La venta ha sido anulado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventasAnulado";

								}
							})

				</script>';

			}else{
				echo'<script>

				swal({
					  type: "success",
					  title: "La venta ha sido recuperado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "ventas";

								}
							})

				</script>';

			}

				
			}		

		}

	}





}