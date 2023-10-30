<?php 
require_once "conexion.php";

/**
 * 
 */
class ModelosRemisiones
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

	static public function mdlAnularRemisionCab($tabla, $datos){

		date_default_timezone_set("America/Asuncion");
		$fecha = date('Y-m-d');
		$hora = date('H:i:s');
		$fechaActual = $fecha.' '.$hora;

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		
		if ($datos["estado"]==1){
			$estadoremision=0;
			
		}else{
				$estadoremision=1;
				
			}
		

		$consultarRemision = $connection->prepare("SELECT r.SUCURSAL_A,r.COD_SUCURSAL,dr.CANTIDAD,dr.COD_PRODUCTO,s.EXISTENCIA,s.COD_STOCK FROM remision r INNER JOIN det_remision dr ON r.COD_REMISION=dr.COD_REMISION INNER JOIN stocks s ON s.COD_PRODUCTO=dr.COD_PRODUCTO WHERE r.TOKEN_REMISION=:tokenRemision and s.COD_SUCURSAL=:codigoSucursal AND ESTADO_REMISION=:estadoremision");

		$consultarRemision -> bindParam(":tokenRemision", $datos["token_remision"], PDO::PARAM_STR);
		$consultarRemision -> bindParam(":codigoSucursal", $datos["codigoSucursal"], PDO::PARAM_STR);
		$consultarRemision -> bindParam(":estadoremision", $datos["estado"], PDO::PARAM_STR);
		$consultarRemision -> execute();

		$consultarRemision = $consultarRemision -> fetchall();

			foreach ($consultarRemision as $key => $value) {


				//PARA AUMENTAR EL STOCK DE LA SUCURSAL ACTUAL


				if ($estadoremision==0){
					$aumentar=$value["EXISTENCIA"]+$value["CANTIDAD"];
				}else{
					$aumentar=$value["EXISTENCIA"]-$value["CANTIDAD"];
				}
			

				$stockaumentar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:aumento WHERE COD_STOCK=:codstock");
				$stockaumentar->bindParam(":codstock", $value["COD_STOCK"], PDO::PARAM_STR);
				$stockaumentar->bindParam(":aumento", $aumentar, PDO::PARAM_STR);
				$stockaumentar->execute();

				//=================================================================================================================

				// DESCONTAR EL STOCK DE LA SUCURSAL A DONDE SE ENVIO

				$consultarRemisionHasta = $connection->prepare("SELECT s.EXISTENCIA,s.COD_STOCK FROM stocks s WHERE COD_SUCURSAL=:codigoSucursal and COD_PRODUCTO=:codigoProducto");

				$consultarRemisionHasta -> bindParam(":codigoSucursal", $value["SUCURSAL_A"], PDO::PARAM_STR);
				$consultarRemisionHasta -> bindParam(":codigoProducto", $value["COD_PRODUCTO"], PDO::PARAM_STR);
		
			$consultarRemisionHasta -> execute();
			$consultarRemisionHasta = $consultarRemisionHasta -> fetch();

					if ($estadoremision==0){
						$descontar=$consultarRemisionHasta["EXISTENCIA"]-$value["CANTIDAD"];
					}else{
						$descontar=$consultarRemisionHasta["EXISTENCIA"]+$value["CANTIDAD"];
					}

				
				$stockdescontar = $connection->prepare("UPDATE stocks SET EXISTENCIA=:descuento WHERE COD_STOCK=:codstock");
				$stockdescontar->bindParam(":codstock",$consultarRemisionHasta["COD_STOCK"], PDO::PARAM_STR);
				$stockdescontar->bindParam(":descuento", $descontar, PDO::PARAM_STR);
				$stockdescontar->execute();

			//============================HASTA ACA===============================================================


			}



		$actualizarCabecera = $connection->prepare("UPDATE $tabla SET FECHA_ANULACION=:fechaAnulado,DESCRIPCION_ANULACION=:descripcion,COD_USUARIO_ANULADO=:id_usuario,ESTADO_REMISION=:estado WHERE TOKEN_REMISION=:tokenRemision");

		$actualizarCabecera->bindParam(":tokenRemision", $datos["token_remision"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":fechaAnulado", $fechaActual, PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":id_usuario", $datos["usuario"], PDO::PARAM_STR);
		$actualizarCabecera->bindParam(":estado", $estadoremision, PDO::PARAM_STR);
			

		if($actualizarCabecera->execute()){

			$connection->commit();
			return "ok";
		}else{
			$connection->rollBack();
			return "error";

		}

 			
			

}




static public function mdlMostrarRemisiondet($tabla,$item,$valor)
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

	static public function mdlIngresarRemisionCab($tabla, $datos){

		$connection = Conexion::conectar();

		$connection->beginTransaction();

		$rollback = true;

		$insertCabecera = $connection->prepare("INSERT INTO $tabla(COD_SUCURSAL,COD_USUARIO,NROREMISION, TOTAL_REMISION,ESTADO_REMISION,TOKEN_REMISION,SUCURSAL_A,OBSERVACION) VALUES (:id_sucursal,:id_usuario,:nroremision,:preciototal,:estado,:token,:sucursal_a,:observacion)");

		$insertCabecera->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":nroremision", $datos["nroremision"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":sucursal_a", $datos["sucursal_a"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":token", $datos["token"], PDO::PARAM_STR);
		$insertCabecera->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
		

		if($insertCabecera->execute()){

			$id = $connection->lastInsertId();

			$listaProductos = json_decode($datos["listaProducto"], true);

			
			foreach ($listaProductos as $key => $value) {

				$nombres = explode("/",$value["id"]);
             	$idProducto=$nombres[0];
             	             
             	$StockAnteriorDesde = $connection->prepare("SELECT * FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
             
				$StockAnteriorDesde->bindParam(":codSucursal", $datos["id_sucursal"], PDO::PARAM_STR);
			
				$StockAnteriorDesde->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
				$StockAnteriorDesde -> execute();
				$stockAnterior_D=$StockAnteriorDesde -> fetch();
				
				
				$StockAnteriorHasta = $connection->prepare("SELECT * FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
				$StockAnteriorHasta->bindParam(":codSucursal", $datos["sucursal_a"], PDO::PARAM_STR);
				$StockAnteriorHasta->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
				$StockAnteriorHasta -> execute();
				$stockAnterior_A = $StockAnteriorHasta -> fetch();
			
 				if($stockAnterior_A==null){

 					$tokenStocknuevo = bin2hex(random_bytes(16));
 					$stock=0;
 					$movimientoProducto="TRANSFERENCIA REMISION";
 							
 					$insertStock=$connection->prepare("INSERT INTO stocks(COD_SUCURSAL,COD_PRODUCTO,COD_USUARIO,EXISTENCIA,STOCKMINIMO,PRECIO_CONTADO,PRECIO_OFERTA,ESTADO_OFERTA,ESTANTE,TOKEN_STOCK, EST_ARTICULOS,MOVIMIENTO_PRODUCTO) VALUES (:sucursal,:codigoProducto,:usuario,:txtstock,:txtstockminimo,:txtprecioventa,:txtOferta,:chkoferta,:txtUbicacion,:tokenStock,:estado,:movimiento)");
 					
					$insertStock->bindParam(":sucursal",$datos["sucursal_a"],PDO::PARAM_STR);
					$insertStock->bindParam(":codigoProducto",$idProducto,PDO::PARAM_STR);
					$insertStock->bindParam(":usuario",$datos["id_usuario"],PDO::PARAM_STR);
					$insertStock->bindParam(":txtstock",$stock,PDO::PARAM_STR);
					$insertStock->bindParam(":txtstockminimo",$stockAnterior_D["STOCKMINIMO"],PDO::PARAM_STR);
					$insertStock->bindParam(":txtprecioventa",$stockAnterior_D["PRECIO_CONTADO"],PDO::PARAM_STR);
					$insertStock->bindParam(":txtOferta",$stockAnterior_D["PRECIO_OFERTA"],PDO::PARAM_STR);
					$insertStock->bindParam(":chkoferta",$stockAnterior_D["ESTADO_OFERTA"],PDO::PARAM_STR);
					$insertStock->bindParam(":txtUbicacion",$stockAnterior_D["ESTANTE"],PDO::PARAM_STR);
					$insertStock->bindParam(":tokenStock",$tokenStocknuevo,PDO::PARAM_STR);
					$insertStock->bindParam(":estado",$stockAnterior_D["EST_ARTICULOS"],PDO::PARAM_STR);
					$insertStock->bindParam(":movimiento",$movimientoProducto,PDO::PARAM_STR);
						
			
					    if ($insertStock-> execute()){
					    	$StockAnteriorHasta = $connection->prepare("SELECT EXISTENCIA FROM productos as p INNER JOIN stocks as s ON p.COD_PRODUCTO=s.COD_PRODUCTO WHERE EST_ARTICULOS=1 AND s.COD_PRODUCTO=:idProducto AND COD_SUCURSAL=:codSucursal");
							$StockAnteriorHasta->bindParam(":codSucursal", $datos["sucursal_a"], PDO::PARAM_STR);
							$StockAnteriorHasta->bindParam(":idProducto", $idProducto, PDO::PARAM_STR);
							$StockAnteriorHasta -> execute();
							$stockAnterior_A = $StockAnteriorHasta -> fetch();
		 				}else{
		 					$connection->rollBack();
		 					
							return "error";
		 				}

 					}


							$Stockresta=$stockAnterior_D["EXISTENCIA"]-$value["cantidad"];


							$StockSuma=$stockAnterior_A["EXISTENCIA"]+ $value["cantidad"];

							$actualizarStock_A = $connection->prepare("UPDATE stocks SET EXISTENCIA=$StockSuma WHERE COD_PRODUCTO =$idProducto AND COD_SUCURSAL=:sucursalA");
							$actualizarStock_A->bindParam(":sucursalA", $datos["sucursal_a"], PDO::PARAM_STR);

							if($actualizarStock_A->execute()){

								$actualizarStock_D = $connection->prepare("UPDATE stocks SET EXISTENCIA=$Stockresta WHERE COD_PRODUCTO =$idProducto AND COD_SUCURSAL=:sucursalD");
								$actualizarStock_D->bindParam(":sucursalD", $datos["id_sucursal"], PDO::PARAM_STR);
								if($actualizarStock_D->execute()){

								}else{
									$connection->rollBack();
									return "error";
								}
							}else{
								$connection->rollBack();
							return "error";

							}

 				$insertdetalle = $connection->prepare("INSERT INTO det_remision(COD_REMISION,COD_PRODUCTO,PREC_UNITARIO,PREC_NETO,CANTIDAD,STOCK_ANTERIOR,STOCK_ANTERIOR_A) VALUES (:codigo,:id_producto,:precio_unitario,:neto,:cantidad,:stock_d,:stock_A)");

				$insertdetalle->bindParam(":codigo", $id, PDO::PARAM_STR);
				$insertdetalle->bindParam(":id_producto", $idProducto, PDO::PARAM_STR);
				$insertdetalle->bindParam(":precio_unitario",$value["precio"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":cantidad", $value["cantidad"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":neto", $value["total"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":stock_d", $stockAnterior_D["EXISTENCIA"], PDO::PARAM_STR);
				$insertdetalle->bindParam(":stock_A",$stockAnterior_A["EXISTENCIA"], PDO::PARAM_STR);

				if($insertdetalle->execute()){

								

				}else{

					$connection->rollBack();
					return "error";
				
				}

			

			}


				$actualizarNumeroRemision = $connection->prepare("UPDATE sucursales SET NROREMISION=:numero WHERE COD_SUCURSAL=:sucursalD");
				$actualizarNumeroRemision->bindParam(":sucursalD", $datos["id_sucursal"], PDO::PARAM_STR);
				$actualizarNumeroRemision->bindParam(":numero", $datos["numeroVerifcador"], PDO::PARAM_STR);
			//	echo '<pre>'; print_r($datos["numeroVerifcador"]); echo '</pre>';
				//return;

						if($actualizarNumeroRemision->execute()){
							$connection->commit();
							return "ok";
						}else{
							$connection->rollBack();
							return "error";
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

	static public function mdlRangoFechasRemision($item,$valor, $fechaInicial, $fechaFinal,$valor1,$fechaColumna){
		
		
		date_default_timezone_set("America/Asuncion");

		if($fechaInicial != 0){

			$fechaini=$fechaInicial.' '.'00:00:00';
			$fechafi= $fechaFinal.' '.'23:59:59';	

		}else{

			$fechaini=date('Y-m-d').' '.'00:00:00';
			$fechafi=date('Y-m-d').' '.'23:59:59';
			
		}
	
			$stmt = Conexion::conectar()->prepare("SELECT r.*,s.SUCURSAL,CONCAT(s.COD_SUCURSAL,'/',
s.TOKEN_SUCURSAL) tokenSucursal,(sa.SUCURSAL) SUCURSAL_A,u.USUARIO FROM remision r INNER JOIN sucursales s ON s.COD_SUCURSAL=r.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=r.COD_USUARIO INNER JOIN sucursales sa ON sa.COD_SUCURSAL=r.SUCURSAL_A WHERE r.$fechaColumna BETWEEN '$fechaini' AND '$fechafi' AND s.$item=:sucursal AND r.ESTADO_REMISION=:estado ORDER BY r.COD_REMISION DESC");
		
				
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
		
			$stmt -> execute();

			return $stmt -> fetchAll();

	}


	static public function mdlRangoFechasDetRemision($item,$valor, $fechaInicial, $fechaFinal,$valor1){
		
		
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

	static public function mdlBusquedaClonar($item,$valor, $item1, $valor1,$valor2){
	
		$stmt = Conexion::conectar()->prepare("SELECT r.OBSERVACION,dr.CANTIDAD,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,r.SUCURSAL_A,sa.TOKEN_SUCURSAL FROM remision r INNER JOIN det_remision dr ON r.COD_REMISION=dr.COD_REMISION INNER JOIN sucursales s ON s.COD_SUCURSAL=r.COD_SUCURSAL INNER JOIN productos p ON dr.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales sa ON sa.COD_SUCURSAL=r.SUCURSAL_A WHERE r.$item1=:token AND s.$item=:sucursal AND r.ESTADO_REMISION=:estado ORDER BY r.$item1 DESC");
		
				
				$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();

			return $stmt -> fetchAll();

	}


	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlBusquedaDetalle($item,$valor, $item1, $valor1,$valor2){
	
		$stmt = Conexion::conectar()->prepare("SELECT r.*,dr.*,p.CODBARRA,p.DESCRIPCION,p.TOKEN_PRODUCTO,p.COD_PRODUCTO,s.SUCURSAL,(sa.SUCURSAL) SUCURSAL_A,u.USUARIO FROM remision r INNER JOIN det_remision dr ON r.COD_REMISION=dr.COD_REMISION INNER JOIN productos p ON dr.COD_PRODUCTO = p.COD_PRODUCTO INNER JOIN sucursales s ON s.COD_SUCURSAL=r.COD_SUCURSAL INNER JOIN usuarios u ON u.COD_USUARIO=r.COD_USUARIO INNER JOIN sucursales sa ON sa.COD_SUCURSAL=r.SUCURSAL_A WHERE r.$item1=:token AND s.$item=:sucursal AND r.ESTADO_REMISION=:estado ORDER BY r.$item1 DESC");
		
				
				$stmt -> bindParam(":estado", $valor2, PDO::PARAM_STR);
				$stmt -> bindParam(":sucursal", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":token", $valor1, PDO::PARAM_STR);
		
			$stmt -> execute();

			return $stmt -> fetchAll();

	}




}