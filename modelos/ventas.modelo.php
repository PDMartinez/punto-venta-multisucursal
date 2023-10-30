<?php 
require_once "conexion.php";

/**
 * 
 */
class ModelosVentas
{
	
	

	static public function mdlConsultarCombos($tabla,$item,$valor,$select){

		$stmt=Conexion::conectar()->prepare("SELECT $select FROM $tabla WHERE $item=:$item ");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt-> execute();
			return $stmt -> fetch();

	}


 	static public function mdlControlarStock($datos){

			// EVALUAMOS SI HAY ESTOCK O NO
			$listaProductos = json_decode($datos["listaProducto"], true);
			

			foreach ($listaProductos as $key => $value) {

				if ($datos["avisoStock"] === "1" && $value["tipoProducto"] === "SOLITARIO") {

					$nombres = explode("/",$value["id"]);
	             	$idProducto=$nombres[0];
             		
             			$StockAnteriorDesde=Conexion::conectar()->prepare("SELECT EXISTENCIA,DESCRIPCION FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal AND TIPO_PRODUCTO='SOLITARIO' ");
             			
		             	$StockAnteriorDesde->bindParam(":codSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
						$StockAnteriorDesde->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
						$StockAnteriorDesde -> execute();
					
						$stockAnterior_D=$StockAnteriorDesde -> fetch();
					
						    if ($stockAnterior_D["EXISTENCIA"] < $value["cantidad"]) {

								return $stockAnterior_D["DESCRIPCION"];
								
						    }
					}

			}
 	}


// 		static public function mdlMostrarCanalProducto($item, $valor,$item1, $valor1,$item2,$valor2){

			
// 		$stmt=Conexion::conectar()->prepare("SELECT p.COD_PRODUCTO,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, TOKEN_PRODUCTO,EXISTENCIA,DESC_CANAL,
// CANTIDAD_DESDE,CANTIDAD_HASTA,TIPO_PRODUCTO FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL
// 			INNER JOIN detcanal_productos dc ON dc.COD_CANAL=p.COD_CANAL WHERE $item=:$item AND p.$item1 = :$item1 AND s.$item2 = :$item2  ORDER by DESC_CANAL");
// 			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
// 			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
// 			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
// 			$stmt-> execute();
// 			// echo '<pre>'; print_r($stmt); echo '</pre>';
			
// 			return $stmt -> fetchAll();


// 	}

		static public function mdlMostrarCanalProducto($tabla,$tabla1,$seleccionar, $item, $valor,$item1, $valor1,$order){

			
		$stmt=Conexion::conectar()->prepare("SELECT $seleccionar FROM $tabla INNER JOIN $tabla1 ON $tabla.$item=$tabla1.$item WHERE $tabla.$item=:$item AND $tabla.$item1 = :$item1 ORDER by $order");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt-> execute();
			
			return $stmt -> fetchAll();


	}



		static public function mdlMostrarProductoCodigoBarra($item, $valor,$item1, $valor1,$item2,$valor2){

			
		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, CONCAT(DESCRIPCION,' ',NOMBRE_MARCA) PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,	COD_CANAL FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE $item=:$item AND p.$item1 = :$item1 AND s.$item2 = :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
			$stmt-> execute();
			// echo '<pre>'; print_r($stmt); echo '</pre>';
			
			return $stmt -> fetch();


	}


	static public function mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3,$valor3,$var){

	
	if ($var=="0"){
	

		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,NOMBRE_MARCA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE $item=:$item AND $item1 <>:$item1 AND s.$item2 <> :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		
			$stmt-> execute();
			return $stmt -> fetchAll();

	}

		if($valor1=="MasVendidos"){
			$stmt=Conexion::conectar()->prepare("SELECT SUM(CANTIDAD) CANTIDADES,st.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,NOMBRE_MARCA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO, TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL  FROM ventas v INNER JOIN detventas dv ON v.COD_FACTURA=dv.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL INNER JOIN stocks st ON st.COD_PRODUCTO=p.COD_PRODUCTO  INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE s.$item2 =:$item2 and st.$item2=:$item2 GROUP BY p.COD_PRODUCTO ORDER BY SUM(dv.CANTIDAD) DESC LIMIT 0,10");
			
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);

			$stmt-> execute();
			return $stmt -> fetchAll();
		

		}else if($valor1=="MasRecientes"){
			

			$stmt=Conexion::conectar()->prepare("SELECT DISTINCT(s.COD_STOCK),p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,NOMBRE_MARCA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO, TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL FROM ventas v INNER JOIN detventas dv ON dv.COD_FACTURA=v.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE s.$item2 = :$item2 ORDER BY dv.COD_DETVENTA DESC LIMIT 0, 10");
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);

			$stmt-> execute();
			
			return $stmt -> fetchAll();
		}

		if ($item3==null){

			$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,NOMBRE_MARCA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL  FROM productos p  INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE $item=:$item AND $item1 $var :$item1 AND s.$item2 = :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		
			$stmt-> execute();
			// echo '<pre>'; print_r($stmt); echo '</pre>';
			
			return $stmt -> fetchAll();

		}else{
			
		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,NOMBRE_MARCA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,	COD_CANAL FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA WHERE $item=:$item AND $item1 = :$item1 AND s.$item2 = :$item2 AND $item3=:$item3  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
			$stmt->bindParam(":".$item3,$valor3,PDO::PARAM_STR);
			$stmt-> execute();
		//	echo '<pre>'; print_r($stmt); echo '</pre>';
			
			return $stmt -> fetch();

		}

	}


	/*=============================================
	CREAR PEDIDOS CABECERA
	=============================================*/

	static public function mdlAnularVentaCab($tabla, $datos){

		date_default_timezone_set("America/Asuncion");
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaActual = $fecha.' '.$hora;

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		
		if ($datos["estado"]==1){
			$estadoventa=0;
			
		}else{
			$estadoventa=1;
				
			}
		

		$consultarventa = $connection->prepare("SELECT dt.CANTIDAD,dt.COD_PRODUCTO,s.EXISTENCIA,s.COD_STOCK,TIPO_PRODUCTO,COMBOS FROM ventas v INNER JOIN detventas dt ON v.COD_FACTURA=dt.COD_FACTURA INNER JOIN stocks s ON s.COD_PRODUCTO=dt.COD_PRODUCTO INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE v.TOKEN_VENTA=:tokenventa and s.COD_SUCURSAL=:codigoSucursal AND 	ESTADO_FACTURA=:estadoventa");


		$consultarventa -> bindParam(":tokenventa", $datos["token_venta"], PDO::PARAM_STR);
		$consultarventa -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
		$consultarventa -> bindParam(":estadoventa", $datos["estado"], PDO::PARAM_STR);
				
		$consultarventa -> execute();

		$consultarventa = $consultarventa -> fetchall();
		

			foreach ($consultarventa as $key => $value) {

			$cantidadVenta=$value["CANTIDAD"];

				//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL
				if ($value["TIPO_PRODUCTO"]=="SOLITARIO"){

					if ($estadoventa==0){
						$aumentar=$value["EXISTENCIA"]+$cantidadVenta;
					}else{
						$aumentar=$value["EXISTENCIA"]-$cantidadVenta;
					}

				$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
				$stockaumentar->bindParam(":codstock", $value["COD_STOCK"], PDO::PARAM_STR);
				$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
				$stockaumentar->execute();
				}elseif ($value["TIPO_PRODUCTO"]=="COMBOS") {

  					$combosnuevos = json_decode($value["COMBOS"], true);
  				

  					if ($combosnuevos!="" && $combosnuevos!=null){
				  			
				  			//var_dump($galeria);
						foreach ($combosnuevos as $indice => $valor) {

							$nombres = explode("/",$valor["id"]);
							$cant=$valor["cantidad"];
								
							$codigoproducto=$nombres[0];


							$consultarproducto = $connection->prepare("SELECT s.EXISTENCIA,s.COD_STOCK FROM stocks s INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE s.COD_PRODUCTO=:codproducto and s.COD_SUCURSAL=:codigoSucursal ");
							$consultarproducto -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
							$consultarproducto->bindParam(":codproducto", $codigoproducto, PDO::PARAM_STR);

							$consultarproducto -> execute();

							$consultarproducto = $consultarproducto -> fetch();
							//echo '<pre>'; print_r($consultarproducto["EXISTENCIA"]); echo '</pre>';

							if ($estadoventa==0){
								$aumentar=$consultarproducto["EXISTENCIA"]+$cant;
								
							}else{
								$aumentar=$consultarproducto["EXISTENCIA"]-$cant;
							}

							$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
							$stockaumentar->bindParam(":codstock", $consultarproducto["COD_STOCK"], PDO::PARAM_STR);
							$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
							
							if ($stockaumentar->execute()){

							}else{
								$connection->rollBack();
								return "error";

							}
													
								}
						}
				
					}

			
				//=================================================================================================================

				
			}



		$actualizarCabecera = $connection->prepare("UPDATE $tabla SET FECHA_ANULADA=:fechaAnulado,DESCRIPCION_ANULACION=:descripcion,USUARIO_ANULADO=:id_usuario,ESTADO_FACTURA=:estado WHERE TOKEN_VENTA=:tokenventa");

		$actualizarCabecera->bindParam(":tokenventa", $datos["token_venta"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":fechaAnulado", $fechaActual, PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":id_usuario", $datos["usuario"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":estado", $estadoventa, PDO::PARAM_STR);
			

		if($actualizarCabecera->execute()){

			$connection->commit();
			return "ok";
		}else{
			$connection->rollBack();
			return "error";

		}

 			
			

}




static public function mdlMostrarVentasdet($tabla,$item,$valor)
	{
		# Mostrar todas las ventas
		if($item!= null){

			$stmt=Conexion::conectar()->prepare("SELECT sum(PRECIOS_NETOS) total FROM $tabla WHERE $item=$valor ");

		//	$stmt-> binParam(":".$item,$valor, PDO::PARAM_STR);
		
		$stmt->execute();
		return $stmt->fetch();
	}else{

		
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ");
		
		$stmt->execute();
		return $stmt->fetchAll();


		}


	}

		/*=============================================
	CREAR PEDIDOS CABECERA
	=============================================*/

	static public function mdlIngresarVentaCab($tabla, $datos){

		// var_dump($datos["txtEfectivo"]);
		// return;

		$efectivo=str_replace('.','',$datos["txtTotal"]);
		

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		$insertCabecera = $connection->prepare("INSERT INTO $tabla(COD_CLIENTE,COD_USUARIO,COD_SUCURSAL,COD_APERTURA,COD_CAJA,METODO_PAGO,TIPO_MOVIMIENTO,FORMA_PAGO,FECHA_VENTA,TOTAL_VENTA,MONTO_INGRESADO,NRO_MOVIMIENTO,ESTADO_FACTURA,TOKEN_VENTA) VALUES (:cod_clientes,:id_usuario,:id_sucursal,:txtidApertura,:idCaja,:metodopago,:cmbTipoMovimiento,:formapago,:txtFechaVenta,:preciototal,:efectivo,:txtnroVenta,:estado,:token)");

		$insertCabecera->bindParam(":cod_clientes", $datos["cod_clientes"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":txtidApertura", $datos["txtidApertura"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":idCaja", $datos["idCaja"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":metodopago", $datos["metodopago"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":cmbTipoMovimiento", $datos["cmbTipoMovimiento"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":formapago", $datos["formapago"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":txtFechaVenta", $datos["txtFechaVenta"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":efectivo", $efectivo, PDO::PARAM_STR);
		$insertCabecera->bindParam(":txtnroVenta", $datos["txtnroVenta"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":token", $datos["token"], PDO::PARAM_STR);

	
		if($insertCabecera->execute()){
			$id = $connection->lastInsertId();
			$pedidos = json_decode($datos["txtpedidos"], true);
  					
  				if ($pedidos!="" && $pedidos!=null){
				  			
				  			//var_dump($galeria);
					foreach ($pedidos as $indice => $valorPedidos) {

						$pedidosEstado = $connection->prepare("UPDATE pedidos SET ESTADO_PEDIDO=0 WHERE COD_PEDIDO=:codPedidos");
						$pedidosEstado->bindParam(":codPedidos", $valorPedidos["idPedidos"], PDO::PARAM_STR);
						$pedidosEstado->execute();

					}

				}

			// var_dump($id);
			// return;

		
			$nombres = explode("-",$datos["txtnroVenta"]);
            $nroVenta=$nombres[2];
           
            $COLUMNATIPO="NRO_FACTURA";



			if($datos["cmbTipoMovimiento"]=="TICKET"){
					$COLUMNATIPO="NROTICKET";
				}

				$actualizarNumeroFactura = $connection->prepare("UPDATE cajas SET $COLUMNATIPO=:numero WHERE COD_SUCURSAL=:sucursalD AND COD_CAJA=:caja");
				$actualizarNumeroFactura->bindParam(":sucursalD", $datos["id_sucursal"], PDO::PARAM_STR);
				$actualizarNumeroFactura->bindParam(":numero", $nroVenta, PDO::PARAM_STR);
				$actualizarNumeroFactura->bindParam(":caja", $datos["idCaja"], PDO::PARAM_STR);
				//echo '<pre>'; print_r($actualizarNumeroFactura->execute()); echo '</pre>';
				
				if($actualizarNumeroFactura->execute()){
							
				}else{
					$connection->rollBack();
					return "error";
				}

				$listaProductos = json_decode($datos["listaProducto"], true);
			//echo '<pre>'; print_r($listaProductos); echo '</pre>';

			
			foreach ($listaProductos as $key => $value) {

				$nombres = explode("/",$value["id"]);
             	$idProducto=$nombres[0];

             	$StockAnteriorDesde = $connection->prepare("SELECT EXISTENCIA,TIPO_PRODUCTO,COMBOS,s.COD_STOCK FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
		             	$StockAnteriorDesde->bindParam(":codSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
						$StockAnteriorDesde->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
						$StockAnteriorDesde -> execute();
						$stockAnterior_D=$StockAnteriorDesde -> fetch();


				//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL
				if ($stockAnterior_D["TIPO_PRODUCTO"]=="SOLITARIO"){
						
						$StockSuma=$stockAnterior_D["EXISTENCIA"] - $value["cantidad"];

						$actualizarStock_D = $connection->prepare("UPDATE stocks SET EXISTENCIA=$StockSuma WHERE COD_STOCK =:id_stock");

						$actualizarStock_D->bindParam(":id_stock", $stockAnterior_D["COD_STOCK"], PDO::PARAM_STR);

						if($actualizarStock_D->execute()){

										
						}else{
							$connection->rollBack();
							return "error";

						}


				}elseif ($stockAnterior_D["TIPO_PRODUCTO"]=="COMBOS") {

  					$combosnuevos = json_decode($stockAnterior_D["COMBOS"], true);
  					
  					if ($combosnuevos!="" && $combosnuevos!=null){
				  			
				  			//var_dump($galeria);
						foreach ($combosnuevos as $indice => $valor) {

									$nombres = explode("/",$valor["id"]);
									$cant=$valor["cantidad"];

										
									$codigoproducto=$nombres[0];


									$consultarproducto = $connection->prepare("SELECT s.EXISTENCIA,s.COD_STOCK FROM stocks s INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE s.COD_PRODUCTO=:codproducto and s.COD_SUCURSAL=:codigoSucursal");

									$consultarproducto -> bindParam(":codigoSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
									$consultarproducto->bindParam(":codproducto", $codigoproducto, PDO::PARAM_STR);

									$consultarproducto -> execute();

									$consultarproducto = $consultarproducto -> fetch();							

								
									$aumentar=$consultarproducto["EXISTENCIA"]-$cant;

									$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
									$stockaumentar->bindParam(":codstock", $consultarproducto["COD_STOCK"], PDO::PARAM_STR);
									$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
									
									if ($stockaumentar->execute()){


									}else{
										$connection->rollBack();
										return "error";

									}
													
							}
						}
				
					}

			
				//=================================================================================================================

					$precioventa=str_replace('.','',$value["precio"]);
					$precioneto=str_replace('.','',$value["subTotal"]);
					$descuentounitario=str_replace('.','',$value["descuento"]);
					

	 				$insertdetalle = $connection->prepare("INSERT INTO detventas(COD_FACTURA,COD_PRODUCTO,CANTIDAD,PRECIO_UNI,PRECIO_NETO,DESCUENTO,STOCK_ANTERIOR, TOKEN_DETVENTA) VALUES (:codigo,:id_producto,:cantidad,:precio_unitario,:neto,:descuento,:stock_d,:token_detalle)");

					$insertdetalle->bindParam(":codigo", $id, PDO::PARAM_STR);
					$insertdetalle->bindParam(":id_producto", $idProducto, PDO::PARAM_STR);
					$insertdetalle->bindParam(":cantidad", $value["cantidad"], PDO::PARAM_STR);
					$insertdetalle->bindParam(":precio_unitario",$precioventa, PDO::PARAM_STR);
					$insertdetalle->bindParam(":neto",$precioneto , PDO::PARAM_STR);
					$insertdetalle->bindParam(":descuento",$descuentounitario, PDO::PARAM_STR);
					$insertdetalle->bindParam(":stock_d", $stockAnterior_D["EXISTENCIA"], PDO::PARAM_STR);
					$insertdetalle->bindParam(":token_detalle", $datos["token_detalle"], PDO::PARAM_STR);
					

					if($insertdetalle->execute()){
						
								

					}else{

						// $uno=1;
						// echo '<pre>'; print_r($uno); echo '</pre>';

						$connection->rollBack();
						return "error";
					
					}

			

				}	


			if ($datos["formapago"]=="CREDITO"){

				$insertCtasPagar = $connection->prepare("INSERT INTO ctascobrar(COD_FACTURA,CANT_CUOTA,MONTO_CUOTA,TOTAL_CUENTA,FECHA_VENCIMIENTO,FECHA_VENC_PROXIMO,FECHA,TIPO_VENTA,ESTADO_CUENTA,TOKEN_CTASCOBRAR) VALUES (:cod_venta,:cantidad_cuota,:monto_cuota,:preciototal,:fecha_vencimiento,:fecha_vencimiento,:fecha,:cmbTipoPago,:estado,:token)");

					$insertCtasPagar->bindParam(":cod_venta", $id, PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":fecha", $datos["txtFechaVenta"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":cantidad_cuota", $datos["cantidad_cuota"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":monto_cuota", $datos["monto_cuota"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":cmbTipoPago", $datos["tipopago"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":token", $datos["token_ctaspagar"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":estado", $datos["estadoCredito"], PDO::PARAM_STR);


					if($insertCtasPagar->execute()){
						$connection->commit();
						return "ok/".$id;
							
						}else{

							$connection->rollBack();
							return "error";
						
						}
				
			}else{
				$connection->commit();
				return "ok/".$id;	
			}	

						

		}else{

			$connection->rollBack();
			return "error";
		
		}


	}



	/*=============================================
	ACTUALIZAR ESTADO
	=============================================*/

	static public function mdlActualizarVenta($tabla, $item1,$valor1,$item2,$valor2,$item3,$valor3)
	{

	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1=:$item1,$item3=:$item3 WHERE $item2=:$item2");
		
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item3, $valor3, PDO::PARAM_STR);

		if($stmt -> execute())
		{
			return "ok";
		
		}else

		{
			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVenta($item,$valor, $fechaInicial, $fechaFinal,$valor1,$fechaColumna){
		
		
		date_default_timezone_set("America/Asuncion");

		if($fechaInicial != 0){

			$fechaini=$fechaInicial.' '.'00:00:00';
			$fechafi= $fechaFinal.' '.'23:59:59';	

		}else{

			$fechaini=date('Y-m-d').' '.'00:00:00';
			$fechafi=date('Y-m-d').' '.'23:59:59';
			
		}
	
			$stmt = Conexion::conectar()->prepare("SELECT v.COD_FACTURA, NRO_MOVIMIENTO, FECHA_VENTA,TOTAL_VENTA, FORMA_PAGO,TIPO_MOVIMIENTO,METODO_PAGO, TOKEN_VENTA,c.RUC,c.CLIENTE,u.USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_FACTURA,USUARIO_ANULADO,FECHA_ANULADA,DESCRIPCION_ANULACION FROM ventas v INNER JOIN clientes c ON v.COD_CLIENTE=c.COD_CLIENTE INNER JOIN usuarios u ON u.COD_USUARIO=v.COD_USUARIO INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL WHERE v.$fechaColumna BETWEEN '$fechaini' AND '$fechafi' AND s.$item=:sucursal AND v.ESTADO_FACTURA=:estado ORDER BY v.COD_FACTURA DESC");

	
				
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			
			$stmt -> execute();
			return $stmt -> fetchAll();

	}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlPreVenta($item,$valor,$item1,$valor1,$item2,$valor2,$order){
		
	$stmt = Conexion::conectar()->prepare("SELECT p.COD_PEDIDO,FECHA_PEDIDO,FECHA_ANULADA, TIPO_PEDIDO,ESTADO_PEDIDO, TOKEN_PEDIDO,c.RUC,c.CLIENTE,u.USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,SUM(PRECIO_NETO) TOTAL_PEDIDO,DESCRIPCION_ANULACION,USUARIO_ANULADO FROM pedidos p INNER JOIN clientes c ON p.COD_CLIENTE=c.COD_CLIENTE INNER JOIN usuarios u ON u.COD_USUARIO=p.COD_USUARIO INNER JOIN sucursales s ON s.COD_SUCURSAL=p.COD_SUCURSAL INNER JOIN det_pedidos dt ON dt.COD_PEDIDO=p.COD_PEDIDO WHERE $item=:sucursal AND $item1=:estado AND $item2=:tipo GROUP BY p.COD_PEDIDO ORDER BY $order");

			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":tipo", $valor2, PDO::PARAM_STR);
			
			
			$stmt -> execute();
			return $stmt -> fetchAll();

	}



	static public function mdlRangoFechasDetVentas($item,$valor, $fechaInicial, $fechaFinal,$valor1){
		
		
		date_default_timezone_set("America/Asuncion");

		if($fechaInicial != 0){

			$fechaini=$fechaInicial;
			$fechafi= $fechaFinal;	

		}else{

			$fechaini=date('Y-m-d');
			$fechafi=date('Y-m-d');
			
		}
		$stmt = Conexion::conectar()->prepare("SELECT r.*,dr.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,s.SUCURSAL,(sa.SUCURSAL) SUCURSAL_A,u.USUARIO FROM remision r INNER JOIN det_remision dr ON r.COD_REMISION=dr.COD_REMISION INNER JOIN productos p ON dr.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=r.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=r.COD_USUARIO INNER JOIN sucursales sa ON sa.COD_SUCURSAL=r.SUCURSAL_A WHERE r.FECHA_REMISION BETWEEN '$fechaini' AND '$fechafi' AND s.$item=:sucursal AND r.ESTADO_REMISION=:estado ORDER BY r.COD_REMISION DESC");
		
				
				$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);


		
			$stmt -> execute();

			return $stmt -> fetchAll();

	}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlBusquedaClonar($item,$valor, $item1, $valor1,$valor2,$forma){

		if ($forma=="CONTADO"){
		$stmt = Conexion::conectar()->prepare("SELECT v.COD_FACTURA,c.COD_CLIENTE, METODO_PAGO,TIPO_MOVIMIENTO,FORMA_PAGO,NRO_MOVIMIENTO ESTADO_FACTURA, TOKEN_VENTA,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal, concat(c.RUC,'-',c.CLIENTE) NOMBRE_CLIENTE,CONCAT(c.COD_CLIENTE,'/',
c.TOKEN_CLIENTE,'/',c.TIPO_CLIENTE,'/',c.CATEGORIA_CLIENTE) tokenClientes,
s.TOKEN_SUCURSAL,dv.CANTIDAD,TIPO_PRODUCTO,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,EXISTENCIA,PRECIO_UNI,PRECIO_NETO,DESCUENTO,PRECIO_CONTADO,ESTADO_OFERTA,p.COD_CANAL FROM ventas v INNER JOIN detventas dv ON v.COD_FACTURA=dv.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN clientes c ON c.COD_CLIENTE=v.COD_CLIENTE INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL INNER JOIN stocks st ON st.COD_PRODUCTO=p.COD_PRODUCTO  WHERE v.$item1=:token AND s.$item=:sucursal AND v.ESTADO_FACTURA=:estado ORDER BY v.$item1 DESC");
		
			$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();
			
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT v.COD_FACTURA,TIPO_MOVIMIENTO,FORMA_PAGO,NRO_MOVIMIENTO, TOKEN_VENTA,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal, concat(c.RUC,'-',c.CLIENTE) NOMBRE_CLIENTE,CONCAT(c.COD_CLIENTE,'/',
c.TOKEN_CLIENTE,'/',c.TIPO_CLIENTE,'/',c.CATEGORIA_CLIENTE) tokenClientes,
s.TOKEN_SUCURSAL,dv.CANTIDAD,TIPO_PRODUCTO,CANT_CUOTA,MONTO_CUOTA,FECHA_VENCIMIENTO, TIPO_VENTA,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,EXISTENCIA,PRECIO_UNI,PRECIO_NETO,DESCUENTO,PRECIO_CONTADO,ESTADO_OFERTA,p.COD_CANAL FROM ventas v INNER JOIN detventas dv ON v.COD_FACTURA=dv.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN clientes c ON c.COD_CLIENTE=v.COD_CLIENTE INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL INNER JOIN ctascobrar ct ON ct.COD_FACTURA=v.COD_FACTURA INNER JOIN stocks st ON st.COD_PRODUCTO=p.COD_PRODUCTO WHERE v.$item1=:token AND s.$item=:sucursal AND v.ESTADO_FACTURA=:estado ORDER BY v.$item1 DESC");
		
			$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
			$stmt -> execute();
		}
	
		

			return $stmt -> fetchAll();

	}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2){
	
		$stmt = Conexion::conectar()->prepare("SELECT v.COD_FACTURA, NRO_MOVIMIENTO, FECHA_VENTA,TOTAL_VENTA, FORMA_PAGO,TIPO_MOVIMIENTO,METODO_PAGO, TOKEN_VENTA,c.RUC,c.CLIENTE,u.USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_FACTURA,dv.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO FROM ventas v INNER JOIN detventas dv ON v.COD_FACTURA=dv.COD_FACTURA INNER JOIN productos p ON dv.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=v.COD_USUARIO INNER JOIN clientes c ON c.COD_CLIENTE=v.COD_CLIENTE WHERE v.$item1=:token AND s.$item=:sucursal AND v.ESTADO_FACTURA=:estado ORDER BY v.$item1 DESC");
		
				
				$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();
	
			return $stmt -> fetchAll();

	}

	/*=============================================
	MOSTRAR VENTA CABECERA TICKET
	=============================================*/	

	static public function mdlMostrarCabeceraTicket($item, $valor){

		// var_dump($item);
		// var_dump($valor);
		// return;
			
		$stmt=Conexion::conectar()->prepare("SELECT (SELECT NOMBRE_EMPRESA FROM empresas) AS NOMBRE_EMPRESA,(SELECT RUC_EMPRESA FROM empresas) AS RUC_EMPRESA,(SELECT PROPIETARIO_EMPRESA FROM empresas) AS PROPIETARIO_EMPRESA, f.NOMBRE_FUNC, v.NRO_MOVIMIENTO, v.FECHA_VENTA, c.CLIENTE, v.FORMA_PAGO, v.TOTAL_VENTA, s.SUCURSAL, s.RUC, s.DIRECCION, s.ENCARGADO, s.TELEFONO_SUC, v.METODO_PAGO, v.MONTO_INGRESADO FROM ventas AS v INNER JOIN clientes AS c ON v.COD_CLIENTE = c.COD_CLIENTE INNER JOIN usuarios AS u ON v.COD_USUARIO = u.COD_USUARIO INNER JOIN funcionarios AS f ON u.COD_FUNCIONARIO = f.COD_FUNCIONARIO INNER JOIN sucursales AS s ON v.COD_SUCURSAL = s.COD_SUCURSAL WHERE $item = :$item;");

			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt-> execute();
			
			return $stmt -> fetch();


	}

	/*=============================================
	MOSTRAR DETALLE DE TICKET
	=============================================*/	

	static public function mdlMostrarDetalleTicket($item, $valor){

		// var_dump($item);
		// var_dump($valor);
		// return;
			
		$stmt=Conexion::conectar()->prepare("SELECT concat(p.DESCRIPCION, ' ', m.NOMBRE_MARCA) AS DESCRIPCION, dv.CANTIDAD, dv.PRECIO_UNI as NETO, (dv.PRECIO_UNI - dv.DESCUENTO) as BRUTO,  dv.DESCUENTO, dv.PRECIO_NETO as SUBTOTAL FROM ventas AS v INNER JOIN detventas AS dv ON v.COD_FACTURA = dv.COD_FACTURA INNER JOIN productos AS p ON dv.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN marcas AS m ON p.COD_MARCA = m.COD_MARCA WHERE v.COD_FACTURA = :$item;");

			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt-> execute();
			
			return $stmt -> fetchAll();


	}

	/*=============================================
	MOSTRAR METODO PAGO X ID
	=============================================*/	

	static public function mdlMostrarMetodoPagoId($item, $valor){

		// var_dump($item);
		// var_dump($valor);
		// return;
			
		$stmt=Conexion::conectar()->prepare("SELECT * FROM forma_pagos WHERE $item = :$item;");

			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt-> execute();
			
			return $stmt -> fetch();


	}


}