<?php 
require_once "conexion.php";

/**
 * 
 */
class ModelosCompras
{
	
	
	static public function mdlMostrarProducto($item, $valor,$item1, $valor1,$item2,$valor2,$item3,$valor3,$var){

		if($var==0){
			$simbolo="=";

		}else{
				$simbolo="<>";
		}

		if ($item3==null){
			$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, concat(DESCRIPCION, ' ',NOMBRE_MARCA,' ', NOMBRE_CATEGORIA)PRODUCTOS,PRECIO_COMPRA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL FROM productos p INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA INNER JOIN categorias c ON c.COD_CATEGORIA=p.COD_CATEGORIA INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE $item=:$item AND $item1=:$item1 AND $item2 $simbolo :$item2  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
			$stmt-> execute();
			return $stmt -> fetchAll();

		}else{
			
		$stmt=Conexion::conectar()->prepare("SELECT s.COD_STOCK,p.COD_PRODUCTO,CODBARRA, concat(DESCRIPCION, ' ',NOMBRE_MARCA,' ', NOMBRE_CATEGORIA)PRODUCTOS,PRECIO_COMPRA, IMAGEN_PRODUCTO , TOKEN_PRODUCTO,EXISTENCIA,STOCKMINIMO,SUCURSAL FROM productos p INNER JOIN marcas m ON m.COD_MARCA=p.COD_MARCA INNER JOIN categorias c ON c.COD_CATEGORIA=p.COD_CATEGORIA INNER JOIN stocks s ON s.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales su ON su.COD_SUCURSAL=s.COD_SUCURSAL WHERE $item=:$item AND $item1=:$item1 AND $item2 $simbolo :$item2 AND $item3=:$item3  ORDER by PRODUCTOS");
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
			$stmt->bindParam(":".$item3,$valor3,PDO::PARAM_STR);
			$stmt-> execute();
			return $stmt -> fetch();

		}

	}


	/*=============================================
	CREAR PEDIDOS CABECERA
	=============================================*/

	static public function mdlAnularCompraCab($tabla, $datos){

		date_default_timezone_set("America/Asuncion");
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaActual = $fecha.' '.$hora;

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		
		if ($datos["estado"]==1){
			$estadocompra=0;
			
		}else{
			$estadocompra=1;
				
			}
		

		$consultarCompra = $connection->prepare("SELECT dt.CANTIDAD,dt.COD_PRODUCTO,s.EXISTENCIA,s.COD_STOCK FROM compras c INNER JOIN det_compras dt ON c.COD_COMPRA=dt.COD_COMPRA INNER JOIN stocks s ON s.COD_PRODUCTO=dt.COD_PRODUCTO WHERE c.TOKEN_COMPRA=:tokenCompra and s.COD_SUCURSAL=:codigoSucursal AND ESTADO_COMPRA=:estadocompra");

		$consultarCompra -> bindParam(":tokenCompra", $datos["token_compra"], PDO::PARAM_STR);
		$consultarCompra -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
		$consultarCompra -> bindParam(":estadocompra", $datos["estado"], PDO::PARAM_STR);
		$consultarCompra -> execute();

		$consultarCompra = $consultarCompra -> fetchall();

			foreach ($consultarCompra as $key => $value) {


				//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL


				if ($estadocompra==0){
					$aumentar=$value["EXISTENCIA"]-$value["CANTIDAD"];
				}else{
					$aumentar=$value["EXISTENCIA"]+$value["CANTIDAD"];
				}
			

				$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
				$stockaumentar->bindParam(":codstock", $value["COD_STOCK"], PDO::PARAM_STR);
				$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
				$stockaumentar->execute();

				//=================================================================================================================

				
			}



		$actualizarCabecera = $connection->prepare("UPDATE $tabla SET FECHA_ANULADA=:fechaAnulado,DESCRIPCION_ANULACION=:descripcion,USUARIO_ANULADO=:id_usuario,ESTADO_COMPRA=:estado WHERE TOKEN_COMPRA=:tokenCompra");

		$actualizarCabecera->bindParam(":tokenCompra", $datos["token_compra"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":fechaAnulado", $fechaActual, PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":id_usuario", $datos["usuario"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":estado", $estadocompra, PDO::PARAM_STR);
			

		if($actualizarCabecera->execute()){

			$connection->commit();
			return "ok";
		}else{
			$connection->rollBack();
			return "error";

		}

 			
			

}




static public function mdlMostrarComprasdet($tabla,$item,$valor)
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

	static public function mdlIngresarCompraCab($tabla, $datos){
		date_default_timezone_set("America/Asuncion");
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaActual = $fecha.' '.$hora;


		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		$insertCabecera = $connection->prepare("INSERT INTO $tabla(COD_PROVEEDOR,COD_USUARIO,COD_SUCURSAL,NROCOMPRA,FECHA_COMPRA,TOTAL_COMPRA,FORMA_PAGO,TIPO_PAGO,METODO_PAGO,ESTADO_COMPRA,TOKEN_COMPRA,FECHA_REGISTRO) VALUES (:cod_proveedor,:id_usuario,:id_sucursal,:nrocompra,:fechacompra,:preciototal,:formapago,:cmbTipoMovimiento,:metodopago,:estado,:token,:fecha_registro)");

		$insertCabecera->bindParam(":cod_proveedor", $datos["cod_proveedor"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":nrocompra", $datos["nrocompra"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":fechacompra", $datos["fechacompra"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":formapago", $datos["formapago"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":cmbTipoMovimiento", $datos["cmbTipoMovimiento"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":metodopago", $datos["metodopago"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":fecha_registro", $fechaActual, PDO::PARAM_STR);

		if($insertCabecera->execute()){

			$id = $connection->lastInsertId();
			

			$listaProductos = json_decode($datos["listaProducto"], true);
		//	echo '<pre>'; print_r($listaProductos); echo '</pre>';

			
			foreach ($listaProductos as $key => $value) {

				$nombres = explode("/",$value["id"]);
             	$idProducto=$nombres[0];
             	             
             	$StockAnteriorDesde = $connection->prepare("SELECT EXISTENCIA FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
             
				$StockAnteriorDesde->bindParam(":codSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
			
				$StockAnteriorDesde->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
				$StockAnteriorDesde -> execute();
				$stockAnterior_D=$StockAnteriorDesde -> fetch();
				
				
							$StockSuma=$stockAnterior_D["EXISTENCIA"]+ $value["cantidad"];
							

							$actualizarStock_D = $connection->prepare("UPDATE stocks SET EXISTENCIA=$StockSuma WHERE COD_PRODUCTO =$idProducto AND COD_SUCURSAL=:id_sucursal");
							$actualizarStock_D->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
							// echo '<pre>'; print_r($actualizarStock_D); echo '</pre>';
							if($actualizarStock_D->execute()){
								
								

								
							}else{
								$connection->rollBack();
							return "error";

							}

 				$insertdetalle = $connection->prepare("INSERT INTO det_compras(COD_COMPRA,COD_PRODUCTO,PREC_UNITARIO,PREC_NETO,CANTIDAD,STOCK_ANTERIOR,DESCUENTO) VALUES (:codigo,:id_producto,:precio_unitario,:neto,:cantidad,:stock_d,:descuento)");

				$insertdetalle->bindParam(":codigo", $id, PDO::PARAM_STR);
				$insertdetalle->bindParam(":id_producto", $idProducto, PDO::PARAM_STR);
				$insertdetalle->bindParam(":precio_unitario",$value["precio"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":neto", $value["total"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":cantidad", $value["cantidad"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":stock_d", $stockAnterior_D["EXISTENCIA"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":descuento",$value["descuento"], PDO::PARAM_STR);

				if($insertdetalle->execute()){
					

						
							

				}else{

					$connection->rollBack();
					return "error";
				
				}

			

			}	


			if ($datos["formapago"]=="CREDITO"){

				$insertCtasPagar = $connection->prepare("INSERT INTO ctaspagar(COD_COMPRA,FECHA,CANT_CUOTA, MONTO_CUOTA, TOTAL_CUENTA,FECHA_VENCIMIENTO,FECHA_VENC_PROXIMO,TIPO_VENTA,TOKEN_CTASPAGAR,ESTADO_CUENTA) VALUES (:cod_compra,:fecha,:cantidad_cuota,:monto_cuota,:preciototal,:fecha_vencimiento,:fecha_vencimiento,:cmbTipoPago,:token,:estado)");

					$insertCtasPagar->bindParam(":cod_compra", $id, PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":fecha", $datos["fechacompra"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":cantidad_cuota", $datos["cantidad_cuota"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":monto_cuota", $datos["monto_cuota"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":cmbTipoPago", $datos["cmbTipoPago"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":token", $datos["token_ctaspagar"], PDO::PARAM_STR);
					$insertCtasPagar->bindParam(":estado", $datos["estadoCredito"], PDO::PARAM_STR);

					if($insertCtasPagar->execute()){
						
							$connection->commit();
										return "ok";
						}else{

							$connection->rollBack();
							return "error";
						
						}
				
			}else{
				$connection->commit();
				return "ok";	
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

	static public function mdlRangoFechasCompra($item,$valor, $fechaInicial, $fechaFinal,$valor1,$fechaColumna){
		
		
		date_default_timezone_set("America/Asuncion");

		if($fechaInicial != 0){

			$fechaini=$fechaInicial.' '.'00:00:00';
			$fechafi= $fechaFinal.' '.'23:59:59';	

		}else{

			$fechaini=date('Y-m-d').' '.'00:00:00';
			$fechafi=date('Y-m-d').' '.'23:59:59';
			
		}
	
			$stmt = Conexion::conectar()->prepare("SELECT c.COD_COMPRA, NROCOMPRA, FECHA_COMPRA, c.FECHA_REGISTRO,TOTAL_COMPRA,NRORECIBO, FORMA_PAGO,TIPO_PAGO,METODO_PAGO, TOKEN_COMPRA,p.RUC,p.NOMBRE,USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_COMPRA,USUARIO_ANULADO,FECHA_ANULADA,DESCRIPCION_ANULACION FROM compras c INNER JOIN proveedores p ON c.COD_PROVEEDOR=p.COD_PROVEEDOR INNER JOIN usuarios u ON u.COD_USUARIO=c.COD_USUARIO INNER JOIN sucursales s ON s.COD_SUCURSAL=c.COD_SUCURSAL WHERE c.$fechaColumna BETWEEN '$fechaini' AND '$fechafi' AND s.$item=:sucursal AND c.ESTADO_COMPRA=:estado ORDER BY c.COD_COMPRA DESC");
		
				
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
		
			$stmt -> execute();
			return $stmt -> fetchAll();

	}


	static public function mdlRangoFechasDetCompras($item,$valor, $fechaInicial, $fechaFinal,$valor1){
		
		
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
		$stmt = Conexion::conectar()->prepare("SELECT c.COD_COMPRA, NROCOMPRA, FECHA_COMPRA,TOTAL_COMPRA,NRORECIBO, FORMA_PAGO,TIPO_PAGO,METODO_PAGO, TOKEN_COMPRA,concat(pro.RUC,'-',pro.NOMBRE) NOMBRE,USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_COMPRA,dc.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,CONCAT(pro.COD_PROVEEDOR,'/',
pro.TOKEN_PROVEEDOR) tokenProveedores FROM compras c INNER JOIN det_compras dc ON c.COD_COMPRA=dc.COD_COMPRA INNER JOIN productos p ON dc.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=c.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=c.COD_USUARIO INNER JOIN proveedores pro ON pro.COD_PROVEEDOR=c.COD_PROVEEDOR  WHERE c.$item1=:token AND s.$item=:sucursal AND c.ESTADO_COMPRA=:estado ORDER BY c.$item1 DESC");
		
			$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT c.COD_COMPRA, NROCOMPRA, FECHA_COMPRA,TOTAL_COMPRA,NRORECIBO, FORMA_PAGO,TIPO_PAGO,METODO_PAGO, TOKEN_COMPRA,concat(pro.RUC,'-',pro.NOMBRE) NOMBRE,USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_COMPRA,dc.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,CONCAT(pro.COD_PROVEEDOR,'/',
pro.TOKEN_PROVEEDOR) tokenProveedores,	FECHA_VENCIMIENTO,TIPO_VENTA,MONTO_CUOTA,CANT_CUOTA FROM compras c INNER JOIN det_compras dc ON c.COD_COMPRA=dc.COD_COMPRA INNER JOIN productos p ON dc.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=c.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=c.COD_USUARIO INNER JOIN proveedores pro ON pro.COD_PROVEEDOR=c.COD_PROVEEDOR INNER JOIN ctaspagar cta ON cta.COD_COMPRA=c.COD_COMPRA WHERE c.$item1=:token AND s.$item=:sucursal AND c.ESTADO_COMPRA=:estado ORDER BY c.$item1 DESC");
		
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
	
		$stmt = Conexion::conectar()->prepare("SELECT c.COD_COMPRA, NROCOMPRA, FECHA_COMPRA,TOTAL_COMPRA,NRORECIBO, FORMA_PAGO,TIPO_PAGO,METODO_PAGO, TOKEN_COMPRA,concat(pro.RUC,'-',pro.NOMBRE) NOMBRE,USUARIO,SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,ESTADO_COMPRA,dc.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO FROM compras c INNER JOIN det_compras dc ON c.COD_COMPRA=dc.COD_COMPRA INNER JOIN productos p ON dc.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=c.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=c.COD_USUARIO INNER JOIN proveedores pro ON pro.COD_PROVEEDOR=c.COD_PROVEEDOR WHERE c.$item1=:token AND s.$item=:sucursal AND c.ESTADO_COMPRA=:estado ORDER BY c.$item1 DESC");
		
				
				$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();
	
			return $stmt -> fetchAll();

	}




}