<?php 
require_once "conexion.php";

/**
 * 
 */
class ModelosPreVentas
{
	
	

	static public function mdlConsultarCombos($tabla,$item,$valor,$select){

		$stmt=Conexion::conectar()->prepare("SELECT $select FROM $tabla WHERE $item=:$item ");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt-> execute();
			return $stmt -> fetch();

	}

	static public function mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3,$valor3,$var){
	
	if ($var=="0"){
	

		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE $item=:$item AND $item1 <>:$item1 AND s.$item2 <> :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		
			$stmt-> execute();
			return $stmt -> fetchAll();

	}

		if($valor1=="MasVendidos"){
			$stmt=Conexion::conectar()->prepare("SELECT SUM(CANTIDAD) CANTIDADES,st.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO, TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL  FROM ventas v INNER JOIN detventas dv ON v.COD_FACTURA=dv.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=v.COD_SUCURSAL INNER JOIN stocks st ON st.COD_PRODUCTO=p.COD_PRODUCTO WHERE s.$item2 =:$item2 and st.$item2=:$item2 GROUP BY p.COD_PRODUCTO ORDER BY SUM(dv.CANTIDAD) DESC LIMIT 0,10");
			
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);

			$stmt-> execute();
			return $stmt -> fetchAll();
		

		}else if($valor1=="MasRecientes"){
			

			$stmt=Conexion::conectar()->prepare("SELECT DISTINCT(s.COD_STOCK),p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO, TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL FROM ventas v INNER JOIN detventas dv ON dv.COD_FACTURA=v.COD_FACTURA INNER JOIN productos p ON p.COD_PRODUCTO=dv.COD_PRODUCTO INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE s.$item2 = :$item2 ORDER BY dv.COD_DETVENTA DESC LIMIT 0, 10");
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);

			$stmt-> execute();
			
			return $stmt -> fetchAll();
		}

		if ($item3==null){

			$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,COD_CANAL  FROM productos p  INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE $item=:$item AND $item1 $var :$item1 AND s.$item2 = :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		
			$stmt-> execute();
			// echo '<pre>'; print_r($stmt); echo '</pre>';
			
			return $stmt -> fetchAll();

		}else{
			
		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, DESCRIPCION PRODUCTOS,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL,TIPO_PRODUCTO,TOKEN_SUCURSAL,COMBOS,	COD_CANAL FROM productos p INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE $item=:$item AND $item1 = :$item1 AND s.$item2 = :$item2 AND $item3=:$item3  ORDER by PRODUCTOS");
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
		

		// $consultarventa = $connection->prepare("SELECT dt.CANTIDAD,dt.COD_PRODUCTO,s.EXISTENCIA,s.COD_STOCK,TIPO_PRODUCTO,COMBOS FROM ventas v INNER JOIN detventas dt ON v.COD_FACTURA=dt.COD_FACTURA INNER JOIN stocks s ON s.COD_PRODUCTO=dt.COD_PRODUCTO INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE v.TOKEN_VENTA=:tokenventa and s.COD_SUCURSAL=:codigoSucursal AND 	ESTADO_FACTURA=:estadoventa");


		// $consultarventa -> bindParam(":tokenventa", $datos["token_venta"], PDO::PARAM_STR);
		// $consultarventa -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
		// $consultarventa -> bindParam(":estadoventa", $datos["estado"], PDO::PARAM_STR);
				
		// $consultarventa -> execute();

		// $consultarventa = $consultarventa -> fetchall();
		

		// 	foreach ($consultarventa as $key => $value) {

		// 	$cantidadVenta=$value["CANTIDAD"];

		// 		//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL
		// 		if ($value["TIPO_PRODUCTO"]=="SOLITARIO"){

		// 			if ($estadoventa==0){
		// 				$aumentar=$value["EXISTENCIA"]+$cantidadVenta;
		// 			}else{
		// 				$aumentar=$value["EXISTENCIA"]-$cantidadVenta;
		// 			}

		// 		$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
		// 		$stockaumentar->bindParam(":codstock", $value["COD_STOCK"], PDO::PARAM_STR);
		// 		$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
		// 		$stockaumentar->execute();
		// 		}elseif ($value["TIPO_PRODUCTO"]=="COMBOS") {

  // 					$combosnuevos = json_decode($value["COMBOS"], true);
  				

  // 					if ($combosnuevos!="" && $combosnuevos!=null){
				  			
		// 		  			//var_dump($galeria);
		// 				foreach ($combosnuevos as $indice => $valor) {

		// 					$nombres = explode("/",$valor["id"]);
		// 					$cant=$valor["cantidad"];
								
		// 					$codigoproducto=$nombres[0];


		// 					$consultarproducto = $connection->prepare("SELECT s.EXISTENCIA,s.COD_STOCK FROM stocks s INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE s.COD_PRODUCTO=:codproducto and s.COD_SUCURSAL=:codigoSucursal ");
		// 					$consultarproducto -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
		// 					$consultarproducto->bindParam(":codproducto", $codigoproducto, PDO::PARAM_STR);

		// 					$consultarproducto -> execute();

		// 					$consultarproducto = $consultarproducto -> fetch();
		// 					//echo '<pre>'; print_r($consultarproducto["EXISTENCIA"]); echo '</pre>';

		// 					if ($estadoventa==0){
		// 						$aumentar=$consultarproducto["EXISTENCIA"]+$cant;
								
		// 					}else{
		// 						$aumentar=$consultarproducto["EXISTENCIA"]-$cant;
		// 					}

		// 					$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
		// 					$stockaumentar->bindParam(":codstock", $consultarproducto["COD_STOCK"], PDO::PARAM_STR);
		// 					$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
							
		// 					if ($stockaumentar->execute()){

		// 					}else{
		// 						$connection->rollBack();
		// 						return "error";

		// 					}
													
		// 						}
		// 				}
				
		// 			}

			
		// 		//=================================================================================================================

				
		// 	}



		$actualizarCabecera = $connection->prepare("UPDATE $tabla SET FECHA_ANULADA=:fechaAnulado,DESCRIPCION_ANULACION=:descripcion,USUARIO_ANULADO=:id_usuario,ESTADO_PEDIDO=:estado WHERE TOKEN_PEDIDO=:tokenpedido");

		$actualizarCabecera->bindParam(":tokenpedido", $datos["token_pedido"], PDO::PARAM_STR);
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
		

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		$insertCabecera = $connection->prepare("INSERT INTO $tabla(COD_CLIENTE,COD_USUARIO,COD_SUCURSAL,FECHA_PEDIDO,TIPO_PEDIDO,TOKEN_PEDIDO) VALUES (:cod_clientes,:id_usuario,:id_sucursal,:txtFechaPedido,:estado,:token)");

		$insertCabecera->bindParam(":cod_clientes", $datos["cod_clientes"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":txtFechaPedido", $datos["txtFechaPedido"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":token", $datos["token"], PDO::PARAM_STR);

	
		if($insertCabecera->execute()){

			$id = $connection->lastInsertId();
			// echo '<pre>'; print_r($id); echo '</pre>';
			
					$listaProductos = json_decode($datos["listaProducto"], true);
			// echo '<pre>'; print_r($listaProductos); echo '</pre>';

			
			foreach ($listaProductos as $key => $value) {

				$nombres = explode("/",$value["id"]);
             	$idProducto=$nombres[0];

             	$descuentonuevo= str_replace('.','',$value["descuento"]);

      //        	$StockAnteriorDesde = $connection->prepare("SELECT EXISTENCIA,TIPO_PRODUCTO,COMBOS,s.COD_STOCK FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
		    //          	$StockAnteriorDesde->bindParam(":codSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
						// $StockAnteriorDesde->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
						// $StockAnteriorDesde -> execute();
						// $stockAnterior_D=$StockAnteriorDesde -> fetch();


				//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL
				// if ($stockAnterior_D["TIPO_PRODUCTO"]=="SOLITARIO"){
						
				// 		$StockSuma=$stockAnterior_D["EXISTENCIA"] - $value["cantidad"];

				// 		$actualizarStock_D = $connection->prepare("UPDATE stocks SET EXISTENCIA=$StockSuma WHERE COD_STOCK =:id_stock");

				// 		$actualizarStock_D->bindParam(":id_stock", $stockAnterior_D["COD_STOCK"], PDO::PARAM_STR);

				// 		if($actualizarStock_D->execute()){

										
				// 		}else{
				// 			$connection->rollBack();
				// 			return "error";

				// 		}


				// }elseif ($stockAnterior_D["TIPO_PRODUCTO"]=="COMBOS") {

  		// 			$combosnuevos = json_decode($stockAnterior_D["COMBOS"], true);
  					
  		// 			if ($combosnuevos!="" && $combosnuevos!=null){
				  			
				//   			//var_dump($galeria);
				// 		foreach ($combosnuevos as $indice => $valor) {

				// 					$nombres = explode("/",$valor["id"]);
				// 					$cant=$valor["cantidad"];

										
				// 					$codigoproducto=$nombres[0];


				// 					$consultarproducto = $connection->prepare("SELECT s.EXISTENCIA,s.COD_STOCK FROM stocks s INNER JOIN productos p ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE s.COD_PRODUCTO=:codproducto and s.COD_SUCURSAL=:codigoSucursal");

				// 					$consultarproducto -> bindParam(":codigoSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
				// 					$consultarproducto->bindParam(":codproducto", $codigoproducto, PDO::PARAM_STR);

				// 					$consultarproducto -> execute();

				// 					$consultarproducto = $consultarproducto -> fetch();							

								
				// 					$aumentar=$consultarproducto["EXISTENCIA"]-$cant;

				// 					$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
				// 					$stockaumentar->bindParam(":codstock", $consultarproducto["COD_STOCK"], PDO::PARAM_STR);
				// 					$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
									
				// 					if ($stockaumentar->execute()){


				// 					}else{
				// 						$connection->rollBack();
				// 						return "error";

				// 					}
													
				// 			}
				// 		}
				
				// 	}

			
				//=================================================================================================================
  				$ValorMaximo=ModeloVarios::mdlExtraerMaximo("det_pedidos","COD_DETPEDIDOS");
				$token_detalles=bin2hex(random_bytes(16));//se genera el token
				$token_detalle=$token_detalles.$ValorMaximo["maximo"];
           	          
 				$insertdetalle = $connection->prepare("INSERT INTO det_pedidos(COD_PEDIDO,COD_PRODUCTO,CANTIDAD,PRECIO_UNI,PRECIO_NETO,DESCUENTO,TOKEN_DETPEDIDO) VALUES (:codigo,:id_producto,:cantidad,:precio_unitario,:neto,:descuento,:token_detalle)");

				$insertdetalle->bindParam(":codigo", $id, PDO::PARAM_STR);
				$insertdetalle->bindParam(":id_producto", $idProducto, PDO::PARAM_STR);
				$insertdetalle->bindParam(":cantidad", $value["cantidad"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":precio_unitario",$value["precio"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":neto", $value["subTotal"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":descuento", $descuentonuevo, PDO::PARAM_STR);
				$insertdetalle->bindParam(":token_detalle", $token_detalle, PDO::PARAM_STR);
											

				if($insertdetalle->execute()){
					
							

				}else{

					// $uno=1;
					// echo '<pre>'; print_r($uno); echo '</pre>';

					$connection->rollBack();
					return "error";
				
				}

			

			}	


			$connection->commit();
			return "ok/".$id;
						

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

	static public function mdlRangoFechasVenta($item,$valor, $fechaInicial, $fechaFinal,$valor1,$valor2,$fechaColumna){
		
		
		date_default_timezone_set("America/Asuncion");

		if($fechaInicial != 0){

			$fechaini=$fechaInicial.' '.'00:00:00';
			$fechafi= $fechaFinal.' '.'23:59:59';	

		}else{

			$fechaini=date('Y-m-d').' '.'00:00:00';
			$fechafi=date('Y-m-d').' '.'23:59:59';
			
		}
	
			$stmt = Conexion::conectar()->prepare("SELECT p.COD_PEDIDO,FECHA_PEDIDO,FECHA_ANULADA, TIPO_PEDIDO,ESTADO_PEDIDO, TOKEN_PEDIDO,c.RUC,c.CLIENTE,u.USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,SUM(PRECIO_NETO) TOTAL_PEDIDO,DESCRIPCION_ANULACION,USUARIO_ANULADO,DESCUENTO FROM pedidos p INNER JOIN clientes c ON p.COD_CLIENTE=c.COD_CLIENTE INNER JOIN usuarios u ON u.COD_USUARIO=p.COD_USUARIO INNER JOIN sucursales s ON s.COD_SUCURSAL=p.COD_SUCURSAL INNER JOIN det_pedidos dt ON dt.COD_PEDIDO=p.COD_PEDIDO WHERE p.$fechaColumna BETWEEN '$fechaini' AND '$fechafi' AND s.$item=:sucursal AND p.ESTADO_PEDIDO=:estado AND p.TIPO_PEDIDO=:tipo GROUP BY p.COD_PEDIDO ORDER BY p.COD_PEDIDO DESC");

	
				
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":tipo", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			
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

	static public function mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2){

		$stmt = Conexion::conectar()->prepare("SELECT p.COD_PEDIDO,FECHA_PEDIDO,FECHA_ANULADA, TIPO_PEDIDO,ESTADO_PEDIDO, TOKEN_PEDIDO,c.RUC,c.CLIENTE,u.USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,CANTIDAD, PRECIO_UNI,PRECIO_NETO,CODBARRA,DESCRIPCION,TOKEN_PRODUCTO,pro.COD_PRODUCTO,TIPO_PRODUCTO,CONCAT(c.COD_CLIENTE,'/',c.TOKEN_CLIENTE,'/',c.TIPO_CLIENTE,'/',c.CATEGORIA_CLIENTE) tokenClientes,DESCUENTO,pro.COD_CANAL,(round(((PRECIO_CONTADO*100)/PRECIO_COMPRA)-100,2)) PORCENTAJE,PRECIO_CONTADO,ESTADO_OFERTA FROM pedidos p INNER JOIN clientes c ON p.COD_CLIENTE=c.COD_CLIENTE INNER JOIN usuarios u ON u.COD_USUARIO=p.COD_USUARIO INNER JOIN sucursales s ON s.COD_SUCURSAL=p.COD_SUCURSAL INNER JOIN det_pedidos dt ON dt.COD_PEDIDO=p.COD_PEDIDO INNER JOIN productos pro ON dt.COD_PRODUCTO = pro.COD_PRODUCTO INNER JOIN stocks st ON st.COD_PRODUCTO=pro.COD_PRODUCTO WHERE p.$item1=:token AND s.$item=:sucursal AND p.ESTADO_PEDIDO=:estado GROUP by pro.COD_PRODUCTO ORDER BY p.$item1 DESC");
		
				
				$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();
			
				return $stmt -> fetchAll();
		
	
		

	}

	/*=============================================
	MOSTRAR PRE-VENTA CABECERA TICKET
	=============================================*/	

	static public function mdlMostrarCabeceraTicket($item, $valor){

		// var_dump($item);
		// var_dump($valor);
		// return;
			
		$stmt=Conexion::conectar()->prepare("SELECT (SELECT NOMBRE_EMPRESA FROM empresas) AS NOMBRE_EMPRESA,(SELECT RUC_EMPRESA FROM empresas) AS RUC_EMPRESA,(SELECT PROPIETARIO_EMPRESA FROM empresas) AS PROPIETARIO_EMPRESA, p.COD_PEDIDO, f.NOMBRE_FUNC, p.FECHA_PEDIDO, c.CLIENTE, s.SUCURSAL, s.RUC, s.DIRECCION, s.ENCARGADO, s.TELEFONO_SUC FROM pedidos AS p INNER JOIN clientes AS c ON p.COD_CLIENTE = c.COD_CLIENTE INNER JOIN usuarios AS u ON p.COD_USUARIO = u.COD_USUARIO INNER JOIN funcionarios AS f ON u.COD_FUNCIONARIO = f.COD_FUNCIONARIO INNER JOIN sucursales AS s ON p.COD_SUCURSAL = s.COD_SUCURSAL WHERE $item = :$item;");

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
			
		$stmt=Conexion::conectar()->prepare("SELECT concat(p.DESCRIPCION, ' ', m.NOMBRE_MARCA) AS DESCRIPCION, dp.CANTIDAD, dp.PRECIO_UNI as NETO, (dp.PRECIO_UNI - dp.DESCUENTO) as BRUTO, dp.DESCUENTO, dp.PRECIO_NETO as SUBTOTAL FROM det_pedidos AS dp INNER JOIN productos AS p ON dp.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN marcas AS m ON p.COD_MARCA = m.COD_MARCA WHERE dp.COD_PEDIDO = :$item;");

		$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

		$stmt-> execute();
			
		return $stmt -> fetchAll();


	}


}