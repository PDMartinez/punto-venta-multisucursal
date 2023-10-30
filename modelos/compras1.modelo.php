<?php 
require_once "conexion.php";

/**
 * 
 */
class ModelosCompras
{
	
	static public function mdlMostrarCompra($tabla,$item,$valor,$valor1)
	{
		# Mostrar todas las ventas
		if($item!= null){
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=$valor AND ESTADO_VENTAS=$valor1 ORDER BY COD_VENTA DESC ");
		//	$stmt-> binParam(":".$item,$valor,PDO::PARAM_STR);
		// var_dump($stmt);
		$stmt->execute();
		return $stmt->fetchAll();
	}else{

		if($valor1=='EMITIDO'){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ESTADO_VENTAS='EMITIDO' ORDER BY COD_VENTA DESC");
		
		$stmt->execute();
		return $stmt->fetchAll();

		}elseif($valor1=='ANULADO'){
		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ESTADO_VENTAS='ANULADO' ORDER BY COD_VENTA DESC");
		
		$stmt->execute();
		return $stmt->fetchAll();


		}else{
			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY COD_VENTA DESC");
		
		$stmt->execute();
		return $stmt->fetchAll();


		}

		}


	}


static public function mdlMostrarCompradet($tabla,$item,$valor)
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

	/*==================================================================================
	CREAR PEDIDOS CABECERA
	====================================================================================*/

	static public function mdlIngresarCompraCab($tabla, $datos){

		$connection = Conexion::conectar();
		$stmt = $connection->prepare("INSERT INTO $tabla(COD_PROVEEDOR,COD_USUARIO,COD_SUCURSAL,NROCOMPRA,FECHA_COMPRA,TOTAL_COMPRA,NRORECIBO,FORMA_PAGO,TIPO_PAGO,METODO_PAGO,ESTADO_COMPRA,TOKEN_COMPRA) VALUES (:cmbproveedor,:id_usuario,:id_sucursal,:txtnrocompra,:txtFechaCompra,:preciototal,:txtnrorecibo,:cmbFormapago,:cmbTipoMovimiento,:cmbMetodopago,:estado,:token)");


		$stmt->bindParam(":cmbproveedor", $datos["cmbproveedor"], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":id_sucursal", $datos["id_sucursal"], PDO::PARAM_STR);
		$stmt->bindParam(":txtnrocompra", $datos["txtnrocompra"], PDO::PARAM_STR);
		$stmt->bindParam(":txtFechaCompra", $datos["txtFechaCompra"], PDO::PARAM_STR);
		$stmt->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
		$stmt->bindParam(":txtnrorecibo", $datos["txtnrorecibo"], PDO::PARAM_STR);
		$stmt->bindParam(":cmbFormapago", $datos["cmbFormapago"], PDO::PARAM_STR);
		$stmt->bindParam(":cmbTipoMovimiento", $datos["cmbTipoMovimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":cmbMetodopago", $datos["cmbMetodopago"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":token", $datos["token"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			$id = $connection->lastInsertId();

			return $id;

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	CREAR PEDIDOS DETALLE
	=============================================*/

	static public function mdlIngresarCompraDet($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(COD_COMPRA,COD_PRODUCTO,PREC_UNITARIO,PREC_NETO, CANTIDAD,STOCK_ANTERIOR,DESCUENTO) VALUES (:codigo,:id_producto,:precio_unitario,:neto,:cantidad,:stock_A,:descuento)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_producto", $datos["id_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_unitario", $datos["precio_unitario"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["neto"], PDO::PARAM_STR);
		$stmt->bindParam(":descuento", $datos["descuento"], PDO::PARAM_STR);
		$stmt->bindParam(":stock_A", $datos["stock_A"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	CREAR Ctas pagar
	=============================================*/

	static public function mdlIngresarCtaspagar($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(COD_COMPRA,FECHA,CANT_CUOTA,MONTO_CUOTA,TOTAL_CUENTA,FECHA_VENCIMIENTO,TIPO_VENTA, TOKEN_CTASPAGAR ,ESTADO_CUENTA) VALUES (:cod_compra,:fecha,:cantidad_cuota,:monto_cuota,:preciototal,:fecha_vencimiento,:cmbTipoPago,:token,:estado)");

		$stmt->bindParam(":cod_compra", $datos["cod_compra"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad_cuota", $datos["cantidad_cuota"], PDO::PARAM_STR);
		$stmt->bindParam(":monto_cuota", $datos["monto_cuota"], PDO::PARAM_STR);
		$stmt->bindParam(":preciototal", $datos["preciototal"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_vencimiento", $datos["fecha_vencimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":cmbTipoPago", $datos["cmbTipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":token", $datos["token_ctaspagar"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

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

	static public function mdlRangoFechasRemision($tabla,$tabla1,$tabla2,$tabla3,$tabla4, $fechaInicial, $fechaFinal,$valor1){

		if($fechaInicial == null){
			$fecha=date('Y-m-d');
			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*,$tabla1.*,$tabla2.*,$tabla3.*,$tabla4.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_REMISION=$tabla1.COD_REMISION INNER JOIN $tabla2 ON $tabla1.COD_PRODUCTO = $tabla2.COD_PRODUCTO INNER JOIN $tabla3 ON $tabla3.COD_SUCURSAL=$tabla.COD_SUCURSAL INNER JOIN $tabla4 ON $tabla4.COD_USUARIO=$tabla.COD_USUARIO WHERE FECHA_REMISION like '%$fecha%' AND ESTADO_REMISION=:estado ORDER BY $tabla.COD_REMISION DESC");
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);

			$stmt -> execute();
		
			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT $tabla.*,$tabla1.*,$tabla2.*,$tabla3.*,tabla4.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_REMISION=$tabla1.COD_REMISION INNER JOIN $tabla2 ON $tabla1.COD_PRODUCTO = $tabla2.COD_PRODUCTO INNER JOIN $tabla3 ON $tabla3.COD_SUCURSAL=$tabla.COD_SUCURSAL INNER JOIN $tabla4.COD_USUARIO=$tabla.COD_USUARIO  WHERE FECHA_REMISION like '%$fechaFinal%' AND ESTADO_REMISION=:estado ORDER BY COD_REMISION DESC");

			//$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);


			$stmt -> execute();
			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT $tabla.*,$tabla1.*,$tabla2.*,$tabla3.*,tabla4.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_REMISION=$tabla1.COD_REMISION INNER JOIN $tabla2 ON $tabla1.COD_PRODUCTO = $tabla2.COD_PRODUCTO INNER JOIN $tabla3 ON $tabla3.COD_SUCURSAL=$tabla.COD_SUCURSAL INNER JOIN $tabla4.COD_USUARIO=$tabla.COD_USUARIO WHERE FECHA_REMISION BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' AND ESTADO_REMISION=:estado ORDER BY COD_REMISION DESC");
				$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);


			}else{


				$stmt = Conexion::conectar()->prepare("SELECT $tabla.*,$tabla1.*,$tabla2.*,$tabla3.*,tabla4.* FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_REMISION=$tabla1.COD_REMISION INNER JOIN $tabla2 ON $tabla1.COD_PRODUCTO = $tabla2.COD_PRODUCTO INNER JOIN $tabla3 ON $tabla3.COD_SUCURSAL=$tabla.COD_SUCURSAL INNER JOIN $tabla4.COD_USUARIO=$tabla.COD_USUARIO WHERE FECHA_REMISION BETWEEN '$fechaInicial' AND '$fechaFinal' AND ESTADO_REMISION=:estado ORDER BY COD_REMISION DESC");
				$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);


			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();

		}

	}


/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentasDet($tabla,$tabla1, $fechaInicial, $fechaFinal,$valor1){

		if($fechaInicial == null){
			$fecha=date('Y-m-d');
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_VENTA=$tabla1.COD_VENTA WHERE FECHA like '%$fecha%' AND ESTADO_VENTAS=:estado ORDER BY $tabla1.COD_VENTA DESC");
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();	


		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_VENTA=$tabla1.COD_VENTA WHERE FECHA like '%$fechaFinal%' AND ESTADO_VENTAS=:estado ORDER BY $tabla1.COD_VENTA DESC");

			//$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);
			$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);

			
			$stmt -> execute();
			return $stmt -> fetchAll();

		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_VENTA=$tabla1.COD_VENTA WHERE FECHA BETWEEN '$fechaInicial' AND '$fechaFinalMasUno' AND ESTADO_VENTAS=:estado ORDER BY $tabla1.COD_VENTA DESC");
				$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);


			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla INNER JOIN $tabla1 ON $tabla.COD_VENTA=$tabla1.COD_VENTA WHERE FECHA BETWEEN '$fechaInicial' AND '$fechaFinal' AND ESTADO_VENTAS=:estado ORDER BY $tabla1.COD_VENTA DESC");
				$stmt -> bindParam(":estado", $valor1, PDO::PARAM_STR);

			}

			$stmt -> execute();
		var_dump($stmt);
			return $stmt -> fetchAll();

		}


	}

}