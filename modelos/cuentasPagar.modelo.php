<?php 

require_once "conexion.php";


class ModeloCuentasPagar{


	/*============================================================
		MOSTRAR DATOS DE LA TABLA CUENTAS A PAGAR
 	==============================================================*/

	static public function MdlMostrarCuentaPagarInner($item1, $valor1, $item2, $valor2, $item3, $valor3, $tabla1, $tabla2, $order){

		// var_dump($item1);
		// var_dump($valor1);
		// var_dump($item2);
		// var_dump($valor2);
		// var_dump($tabla1);
		// var_dump($tabla2);
		// var_dump($order);

		if($item1 != null){

			$stmt = Conexion::conectar()->prepare("SELECT cp.COD_CUENTA, cp.TOKEN_CTASPAGAR, cp.COD_COMPRA, c.NROCOMPRA, c.TIPO_PAGO, cp.FECHA_VENCIMIENTO, c.FECHA_COMPRA, cp.CANT_CUOTA, cp.MONTO_CUOTA, dcp.PAGO, cp.TOTAL_CUENTA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, FECHA_VENC, FECHA_PAGO FROM ctaspagar AS cp INNER JOIN compras AS c ON cp.COD_COMPRA = c.COD_COMPRA LEFT JOIN detctaspagar dcp ON cp.COD_CUENTA = dcp.COD_CUENTA WHERE COD_SUCURSAL = :$item1 AND COD_PROVEEDOR = :$item2 AND cp.ESTADO_CUENTA = :$item3 GROUP BY COD_CUENTA ORDER BY $order");

			// $stmt = Conexion::conectar()->prepare("SELECT cp.COD_CUENTA, cp.TOKEN_CTASPAGAR, cp.COD_COMPRA, c.NROCOMPRA, c.TIPO_PAGO, cp.FECHA_VENCIMIENTO, c.FECHA_COMPRA, cp.CANT_CUOTA, cp.MONTO_CUOTA, cp.TOTAL_CUENTA FROM $tabla1 AS cp INNER JOIN $tabla2 AS c ON cp.COD_COMPRA = c.COD_COMPRA WHERE $item1 = :$item1 AND $item2 = :$item2 AND $item3 = :$item3 ORDER BY $order");
	           			
			$stmt -> bindParam(":$item1",  $valor1, PDO::PARAM_STR);
			$stmt -> bindParam(":$item2",  $valor2, PDO::PARAM_STR);
			$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;
	 		
	}

	/*============================================================
		MOSTRAR DATOS DE LA TABLA CUENTAS A PAGAR
 	==============================================================*/

	static public function mdlMostrarProveedorCuentaPagar($item, $valor, $where){

		// var_dump($where);
		// return;

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT p.*, cp.* FROM proveedores AS p INNER JOIN compras AS c ON p.COD_PROVEEDOR = c.COD_PROVEEDOR INNER JOIN ctaspagar AS cp  ON c.COD_COMPRA = cp.COD_COMPRA $where");

			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt = null;

	 		
	}



	/*============================================================
		MOSTRAR DATOS DE CUENTAS A PAGAR PARA EL LISTADO PRINCIPAL
 	==============================================================*/

	static public function mdlMostrarCuentasPagarListado($valor1, $valor2, $item3, $valor3, $valor4, $item5, $valor5){

		date_default_timezone_set("America/Asuncion");

		// var_dump($valor1);
		// var_dump($valor2);
		// var_dump($valor3);
		// var_dump($valor4);
		// var_dump($valor5);

		/*============================================================
		INGRESA AQUI SI SE PASA EL DATO DEL PROVEEDOR
	 	==============================================================*/

		if($valor5 == 0){

			if($valor1 != 0){;

				$fechaini=$valor1.' '.'00:00:00';
				$fechafi= $valor2.' '.'23:59:59';	

			}else{

				$fechaini=date('Y-m-d').' '.'00:00:00';
				$fechafi=date('Y-m-d').' '.'23:59:59';
				
			}

			$stmt = Conexion::conectar()->prepare("SELECT c.NROCOMPRA, c.TIPO_PAGO, p.COD_PROVEEDOR, p.TOKEN_PROVEEDOR, p.NOMBRE, p.RUC, c.FECHA_COMPRA, cp.FECHA_VENC_PROXIMO, cp.COD_CUENTA, cp.TOTAL_CUENTA, cp.MONTO_CUOTA, cp.CANT_CUOTA, cp.TIPO_VENTA, cp.ESTADO_CUENTA, cp.TOKEN_CTASPAGAR, dcp.PAGO, ((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA) AS CUOTA_PAGADA, SUM(dcp.PAGO) AS MONTO_PAGADO FROM proveedores AS p INNER JOIN compras AS c ON p.COD_PROVEEDOR = c.COD_PROVEEDOR INNER JOIN ctaspagar AS cp ON c.COD_COMPRA = cp.COD_COMPRA LEFT JOIN detctaspagar AS dcp ON cp.COD_CUENTA = dcp.COD_CUENTA WHERE cp.FECHA BETWEEN '$fechaini' AND '$fechafi' AND cp.ESTADO_CUENTA = '$valor4' AND c.COD_SUCURSAL = :$item3 GROUP BY cp.COD_CUENTA;");

			$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

			/*============================================================
			SINO SE PASA EL DATO DE PROVEEDOR INGRESA AQUI
		 	==============================================================*/

		 	/*============================================================
			SI SE PASA FECHA COMO PARAMETRO
		 	==============================================================*/

			if($valor1 != 0){;

				$fechaini=$valor1.' '.'00:00:00';
				$fechafi= $valor2.' '.'23:59:59';

				$stmt = Conexion::conectar()->prepare("SELECT c.NROCOMPRA, c.TIPO_PAGO, p.COD_PROVEEDOR, p.TOKEN_PROVEEDOR, p.NOMBRE, p.RUC, c.FECHA_COMPRA, cp.FECHA_VENC_PROXIMO, cp.COD_CUENTA, cp.TOTAL_CUENTA, cp.MONTO_CUOTA, cp.CANT_CUOTA, cp.TIPO_VENTA, cp.ESTADO_CUENTA, cp.TOKEN_CTASPAGAR, dcp.PAGO, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcp.PAGO) AS MONTO_PAGADO FROM proveedores AS p INNER JOIN compras AS c ON p.COD_PROVEEDOR = c.COD_PROVEEDOR INNER JOIN ctaspagar AS cp ON c.COD_COMPRA = cp.COD_COMPRA LEFT JOIN detctaspagar AS dcp ON cp.COD_CUENTA = dcp.COD_CUENTA WHERE cp.FECHA BETWEEN '$fechaini' AND '$fechafi' AND cp.ESTADO_CUENTA = '$valor4' AND c.COD_SUCURSAL = :$item3 AND c.COD_PROVEEDOR = :$item5 GROUP BY cp.COD_CUENTA;");

		 		$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);
				$stmt -> bindParam(":$item5",  $valor5, PDO::PARAM_STR);

				$stmt -> execute();
					
				return $stmt -> fetchAll();	

			}else{

				/*============================================================
				SI NO SE PASA FECHA COMO PARAMETRO
			 	==============================================================*/

			 	$fechaini=date('Y-m-d').' '.'00:00:00';
				$fechafi=date('Y-m-d').' '.'23:59:59';

				// var_dump($fechaini);
				// var_dump($fechafi);

				$stmt = Conexion::conectar()->prepare("SELECT c.NROCOMPRA, c.TIPO_PAGO, p.COD_PROVEEDOR, p.TOKEN_PROVEEDOR, p.NOMBRE, p.RUC, c.FECHA_COMPRA, cp.FECHA_VENC_PROXIMO, cp.COD_CUENTA, cp.TOTAL_CUENTA, cp.MONTO_CUOTA, cp.CANT_CUOTA, cp.TIPO_VENTA, cp.ESTADO_CUENTA, cp.TOKEN_CTASPAGAR, dcp.PAGO, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcp.PAGO) AS MONTO_PAGADO FROM proveedores AS p INNER JOIN compras AS c ON p.COD_PROVEEDOR = c.COD_PROVEEDOR INNER JOIN ctaspagar AS cp ON c.COD_COMPRA = cp.COD_COMPRA LEFT JOIN detctaspagar AS dcp ON cp.COD_CUENTA = dcp.COD_CUENTA WHERE  cp.ESTADO_CUENTA = '$valor4' AND c.COD_SUCURSAL = :$item3 AND c.COD_PROVEEDOR = :$item5 GROUP BY cp.COD_CUENTA;");

		 		$stmt -> bindParam(":$item3",  $valor3, PDO::PARAM_STR);
				$stmt -> bindParam(":$item5",  $valor5, PDO::PARAM_STR);

				$stmt -> execute();
					
				return $stmt -> fetchAll();
				
			}

	 	}

	 	$stmt-> close();
		$stmt = null;

	 		
	}

	/*============================================================
		MOSTRAR CUENTAS A PAGAR
 	==============================================================*/

	static public function mdlMostrarCuentasPagar($tabla, $item, $valor, $order){

		if($item != null){

			// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
			$stmt = Conexion::conectar()->prepare("SELECT cp.CANT_CUOTA, cp.FECHA_VENC_PROXIMO, cp.TIPO_VENTA, cp.MONTO_CUOTA, cp.TOTAL_CUENTA, dcp.PAGO, dcp.SALDO, FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE cp.COD_CUENTA = :$item");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	static public function mdlMostrarCuentasPagarProductos($item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT PREC_UNITARIO,PREC_NETO,CANTIDAD,STOCK_ANTERIOR,DESCUENTO,DESCRIPCION,CODBARRA FROM compras c INNER JOIN det_compras dt ON c.COD_COMPRA=dt.COD_COMPRA INNER JOIN proveedores p ON p.COD_PROVEEDOR=c.COD_PROVEEDOR INNER JOIN productos pro ON pro.COD_PRODUCTO=dt.COD_PRODUCTO INNER JOIN ctaspagar ct ON ct.COD_COMPRA=c.COD_COMPRA WHERE $item = :$item ORDER BY $order ");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetchAll();

		}else{

	 		$stmt = Conexion::conectar()->prepare("SELECT PREC_UNITARIO,PREC_NETO,CANTIDAD,STOCK_ANTERIOR,DESCUENTO,DESCRIPCION,CODBARRA FROM compras c INNER JOIN det_compras dt ON c.COD_COMPRA=dt.COD_COMPRA INNER JOIN proveedores p ON p.COD_PROVEEDOR=c.COD_PROVEEDOR INNER JOIN productos pro ON pro.COD_PRODUCTO=dt.COD_PRODUCTO INNER JOIN ctaspagar ct ON ct.COD_COMPRA=c.COD_COMPRA ORDER BY $order ");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}


	/*============================================================
		MOSTRAR DETALLES DE CUENTAS A PAGAR
 	==============================================================*/

	static public function mdlMostrarDetCuentasPagar($tabla, $item, $valor, $order){

		if($item != null){

			// $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order");
			$stmt = Conexion::conectar()->prepare("SELECT TOTAL_CUENTA, CANT_CUOTA, MONTO_CUOTA, PAGO, FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, FECHA_VENC, FECHA_PAGO FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE $item = $valor ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		MOSTRAR DIFERENCIA FECHA
 	==============================================================*/

	static public function mdlMostrarDiferenciaFecha($item, $valor, $where){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT p.NOMBRE, p.RUC, p.CELULAR, cp.TOTAL_CUENTA, cp.OBSERVACIONES, dcp.FECHA_VENC, dcp.FECHA_PAGO, dcp.DET_MOVIMIENTO FROM proveedores AS p INNER JOIN compras AS c ON p.COD_PROVEEDOR = c.COD_PROVEEDOR INNER JOIN ctaspagar AS cp  ON c.COD_COMPRA = cp.COD_COMPRA LEFT JOIN detctaspagar AS dcp ON cp.COD_CUENTA = dcp.COD_CUENTA $where");

			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}


	/*============================================================
		MOSTRAR NUMERO DE RECIBO
 	==============================================================*/

	static public function mdlMostrarNroRecibo($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT MAX(NRO_RECIBO) AS NRO_RECIBO FROM $tabla WHERE $item = :$item;");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;
	}

	/*============================================================
		MOSTRAR CANTIDAD DE PAGOS DE CUENTAS
 	==============================================================*/

	static public function mdlMostrarCantPagoCuenta($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT TOTAL_CUENTA, CANT_CUOTA, PAGO, FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, SUM(dcp.PAGO) AS MONTO_PAGADO FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE $item = $valor ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;
	}

	/*============================================================
		MOSTRAR DETALLES DE CUENTAS A PAGAR
 	==============================================================*/

	static public function mdlMostrarDetCuentasPagar1($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		CREAR PAGOS
 	==============================================================*/
	static public function mdlIngresarPago($tabla, $datos){

		// var_dump($datos);
		// return;

		/*=======================================================================
		CONSULTAMOS LA FECHA DE VECIMIENTO PARA AUMENTARLE SEGUN EL TIPO DE VENTA
 		========================================================================*/
		$consultarVenc = Conexion::conectar()->prepare("SELECT * FROM ctaspagar WHERE COD_CUENTA = :codCuenta");
		$consultarVenc->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
		$consultarVenc -> execute();
		$fechaVenc = $consultarVenc -> fetch(PDO::FETCH_ASSOC);

		// var_dump($fechaVenc["TOTAL_CUENTA"]);
		// var_dump($fechaVenc["FECHA_VENCIMIENTO"]);
		// return;

		$totalCuenta = intval($fechaVenc["TOTAL_CUENTA"]);
		$fecha = new DateTime($fechaVenc["FECHA_VENCIMIENTO"]);
		$fechaAdd;

		/*=======================================================================
		CONSULTAMOS EL TOTAL PAGADO DE LA CUENTA PARA CALCULAR SALDO
 		========================================================================*/
		$consultarSaldo = Conexion::conectar()->prepare("SELECT SUM(pago) AS PAGO_TOTAL FROM detctaspagar WHERE COD_CUENTA = :codCuenta");	
		$consultarSaldo->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
		$consultarSaldo -> execute();
		$saldoConsultado = $consultarSaldo -> fetch(PDO::FETCH_ASSOC);
		$saldo = intval($saldoConsultado["PAGO_TOTAL"]);
		$saldoFinal;
		$estadoCuenta = "CREDITO";


		// var_dump($saldo);
		// var_dump(intval($datos["pago"]));
		// return;

		if($datos["tipoRecibo"] == "AUTOMATICO"){

			/*=======================================================================
			CONSULTAMOS EL NUMERO DE RECIBO
	 		========================================================================*/
			$consultarRecibo = Conexion::conectar()->prepare("SELECT MAX(NRO_RECIBO) AS NRO_RECIBO FROM detctaspagar WHERE TIPO_RECIBO = 'AUTOMATICO'");
			$consultarRecibo->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
			$consultarRecibo -> execute();
			$nroRecibo = $consultarRecibo -> fetch(PDO::FETCH_ASSOC);
			$nroRecibo = intval($nroRecibo["NRO_RECIBO"])+1;

			$datos["nroRecibo"] = $nroRecibo;

		}
		// var_dump($nroRecibo);
		// return;

		/*============================================================
		SI OBTENEMOS LOS REGISTROS PROCEDEMOS A REALIZAR EL INSERT
 		==============================================================*/
		if($totalCuenta > 0){

			// var_dump($datos["tipoVenta"]);
			// return;

			/*============================================================
			PRIMERO: CALCULAMOS EL SALDO POR CADA PAGO QUE SE VA REALIZANDO
	 		==============================================================*/

			if($saldo > 0 ){

				// CALCULAMOS EL SALDO
				$saldoFinal = ($totalCuenta - ($saldo + intval($datos["pago"])));
				
				if($saldoFinal < 1){

					$estadoCuenta = "CANCELADO";

				}

			}else{

				$saldoFinal = ($totalCuenta - intval($datos["pago"]));

				if($saldoFinal < 1){

					$estadoCuenta = "CANCELADO";

				}

			}

			// var_dump($saldoFinal);
			// return;

			$connection = Conexion::conectar();

		    $connection->beginTransaction();

		    $rollback = true;

		    /*============================================================
			SEGUNDO: INSERTAMOS EL REGISTRO DE PAGO DE LA CUENTA
	 		==============================================================*/

			$insert=$connection->prepare("INSERT INTO $tabla(COD_CUENTA, COD_USUARIO, PAGO, FECHA_VENC, SALDO, FECHA_PAGO, ESTADO_CUENTA, FORMAPAGO, NRO_MOVIMIENTO, NRO_RECIBO, TIPO_RECIBO, DET_MOVIMIENTO, AGRUPAR_ANULADO, TOKEN_DETCTASPAGAR) VALUES (:codCuenta, :codUsuario, :pago, :fechaVenc, :saldo, :fechaPago, :estadoCuenta, :formaPago, '0', :nroRecibo, :tipoRecibo, 'PAGO', :agruparAnulado, :token)");
					
			$insert->bindParam(":codCuenta", ($datos["codCuenta"]), PDO::PARAM_STR);
			$insert->bindParam(":codUsuario", ($datos["codUsuario"]), PDO::PARAM_STR);
			$insert->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
			$insert->bindParam(":fechaVenc",$fechaVenc["FECHA_VENC_PROXIMO"], PDO::PARAM_STR);
			$insert->bindParam(":saldo", $saldoFinal, PDO::PARAM_STR);
			$insert->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);
			$insert->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);
			// $insert->bindParam(":nroMovimiento","0", PDO::PARAM_STR);
			$insert->bindParam(":nroRecibo", $datos["nroRecibo"], PDO::PARAM_STR);
			$insert->bindParam(":tipoRecibo", $datos["tipoRecibo"], PDO::PARAM_STR);
			$insert->bindParam(":formaPago", $datos["formaPago"], PDO::PARAM_STR);
			$insert->bindParam(":agruparAnulado", $datos["agruparAnulado"], PDO::PARAM_STR);
			$insert->bindParam(":token", $datos["token"], PDO::PARAM_STR);

			if ($insert-> execute()){

				/*=======================================================================
				  TERCERO: CONSULTAMOS SI SE COMPLETAN LOS PAGOS PARCIALES
		 		========================================================================*/
				$consultarPagoParcial = $connection->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");
				$consultarPagoParcial->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
				$consultarPagoParcial -> execute();
				$pagoParcial = $consultarPagoParcial -> fetch(PDO::FETCH_ASSOC);

				// if($pagoParcial["CUOTA_PAGADA"] == $pagoParcial["CUOTA_PAGADA_DECIMAL"]){

					/*============================================================
					 CUARTO: PREGUNTAMOS EL TIPO DE VENTA PARA AUMENTAR LA FECHA
			 		==============================================================*/

					if($datos["tipoVenta"] == "MENSUAL"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'M'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "QUINCENAL"){

						$fecha->add(new DateInterval('P'.(intval($pagoParcial["CUOTA_PAGADA"])*2).'W'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "SEMANAL"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'W'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}else if($datos["tipoVenta"] == "DIARIO"){

						$fecha->add(new DateInterval('P'.$pagoParcial["CUOTA_PAGADA"].'D'));
						$fechaAdd = date_format($fecha, "Y-m-d");

					}

					// var_dump($fechaAdd);
					// return;

				// }else{

				// 	$fechaAdd = date_format($fecha, "Y-m-d H:i:s");

				// }

				/*=============================================================================================
					 QUINTO: SI SE REALIZA EL INSERT PROCEDEMOS A REALIZAR LA MODIFICACION DE LA FECHA DE VENC
			 	==============================================================================================*/

				$modificar=$connection->prepare("UPDATE ctaspagar SET FECHA_VENC_PROXIMO = :fecha, ESTADO_CUENTA = :estadoCuenta WHERE COD_CUENTA = :codCuenta");

				$modificar->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
				$modificar->bindParam(":fecha", $fechaAdd, PDO::PARAM_STR);
				$modificar->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);

				if($modificar -> execute()){

					$connection->commit();

					return "ok";
				
				}else{

					$connection->rollBack();

					return "error";

				}

			}else{

				return "error";

			}

		}else{

			return "error";

		}

	}

	/*============================================================
		MOSTRAR DETALLES DE LA CUENTA CON USUARIO
 	==============================================================*/

	static public function mdlMostrarHistorialPago($tabla1, $tabla2, $tabla3, $item, $valor, $order){

		// var_dump($tabla1);
		// var_dump($tabla2);
		// var_dump($tabla3);
		// var_dump($item);
		// var_dump($valor);
		// var_dump($order);

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT dcp.*, f.NOMBRE_FUNC FROM $tabla1 AS dcp INNER JOIN $tabla2 AS u ON dcp.COD_USUARIO = u.COD_USUARIO INNER JOIN $tabla3 AS f ON f.COD_FUNCIONARIO = u.COD_FUNCIONARIO WHERE $item = $valor ORDER BY $order");
	           			
			$stmt -> bindParam(":$item",$valor,PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}


	/*============================================================
		MOSTRAR CUENTA CABECERA
 	==============================================================*/

	static public function mdlMostrarCuentasCabecera($tabla, $item, $valor, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT p.NOMBRE, f.NOMBRE_FUNC, s.SUCURSAL, c.NROCOMPRA, c.TIPO_PAGO, c.FORMA_PAGO, c.FECHA_COMPRA, c.TIPO_PAGO, c.TOTAL_COMPRA FROM compras AS c INNER JOIN proveedores AS p ON c.COD_PROVEEDOR = p.COD_PROVEEDOR INNER JOIN sucursales AS s ON c.COD_SUCURSAL = s.COD_SUCURSAL INNER JOIN usuarios AS u ON c.COD_USUARIO = u.COD_USUARIO INNER JOIN funcionarios AS f ON u.COD_FUNCIONARIO = f.COD_FUNCIONARIO INNER JOIN ctaspagar AS cp ON cp.COD_COMPRA = c.COD_COMPRA WHERE $item = :$item ORDER BY $order ");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
				
			return $stmt -> fetch();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		ANULAR PAGO
 	==============================================================*/
	static public function mdlAnularPago($tabla, $datos){

		// var_dump($datos);
		// return;

		$consultarPagoParcialPre = Conexion::conectar()->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, cp.FECHA_VENC_PROXIMO, cp.TIPO_VENTA FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");
		
		$consultarPagoParcialPre->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

		if($consultarPagoParcialPre -> execute()){

			$pagoParcialPre = $consultarPagoParcialPre -> fetch(PDO::FETCH_ASSOC);

			// var_dump($pagoParcialPre["CUOTA_PAGADA"]);
			// return;

			/*=======================================================================
			CONSULTAMOS LA FECHA DE VENCIMIENTO Y EL TOTAL DE ESA CUENTA
	 		========================================================================*/
			$consultarTipoVenta = Conexion::conectar()->prepare("SELECT * FROM ctaspagar WHERE COD_CUENTA = :codCuenta");
			$consultarTipoVenta->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

			if($consultarTipoVenta -> execute()){

				$venta = $consultarTipoVenta -> fetch(PDO::FETCH_ASSOC);
				$fechaVenc = $venta["FECHA_VENCIMIENTO"];
				$totalCuenta = intval($venta["TOTAL_CUENTA"]);
				$montoCuota = intval($venta["MONTO_CUOTA"]);

				// var_dump(intval($datos["pago"])*-1);
				// return;

				/*=======================================================================
				INICIAMOS EN ROLLBACK
		 		========================================================================*/

				$connection = Conexion::conectar();
				$connection->beginTransaction();
				$rollback = true;

				/*=======================================================================
				INSERTAMOS NUESTRO REGISTRO
		 		========================================================================*/

				$insert=$connection->prepare("INSERT INTO $tabla(COD_CUENTA, COD_USUARIO, PAGO, FECHA_VENC, SALDO, FECHA_PAGO, ESTADO_CUENTA, FORMAPAGO ,NRO_MOVIMIENTO, NRO_RECIBO, TIPO_RECIBO, DET_MOVIMIENTO, AGRUPAR_ANULADO, TOKEN_DETCTASPAGAR) VALUES (:codCuenta, :codUsuario, :pago, :fechaVenc, :saldo, :fechaPago, :estadoCuenta, :formaPago, :nroMovimiento, :nroRecibo, :tipoRecibo, :detMovimiento, :agruparAnulado, :token)");
							
				$insert->bindParam(":codCuenta", ($datos["codCuenta"]), PDO::PARAM_STR);
				$insert->bindParam(":codUsuario", ($datos["codUsuario"]), PDO::PARAM_STR);
				$insert->bindParam(":pago", $datos["pago"], PDO::PARAM_STR);
				$insert->bindParam(":fechaVenc",$datos["fechaVenc"], PDO::PARAM_STR);
				$insert->bindParam(":saldo", $datos["saldo"], PDO::PARAM_STR);
				$insert->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);
				$insert->bindParam(":estadoCuenta", $datos["estadoCuenta"], PDO::PARAM_STR);
				$insert->bindParam(":formaPago", $datos["formaPago"], PDO::PARAM_STR);
				$insert->bindParam(":nroMovimiento",$datos["nroMovimiento"], PDO::PARAM_STR);
				$insert->bindParam(":nroRecibo", $datos["nroRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":tipoRecibo", $datos["tipoRecibo"], PDO::PARAM_STR);
				$insert->bindParam(":detMovimiento", $datos["detMovimiento"], PDO::PARAM_STR);
				$insert->bindParam(":agruparAnulado", $datos["agruparAnulado"], PDO::PARAM_STR);
				$insert->bindParam(":token", $datos["token"], PDO::PARAM_STR);

				/*===================================================================================
				SI SE REALIZA EL INSERT PROCEDEMOS A REALIZAR LA CONSULTA DEL PAGO TOTAL DE LA CUENTA
		 		====================================================================================*/
				if ($insert -> execute()){

					$consultarPagoParcial = $connection->prepare("SELECT FLOOR(((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA, (((SUM(dcp.PAGO)*CANT_CUOTA)/TOTAL_CUENTA)) AS CUOTA_PAGADA_DECIMAL, SUM(dcp.PAGO) AS MONTO_PAGADO, ((cp.TOTAL_CUENTA - SUM(dcp.PAGO))) AS SALDO, cp.FECHA_VENC_PROXIMO, cp.TIPO_VENTA FROM ctaspagar cp INNER JOIN detctaspagar dcp ON cp.COD_CUENTA=dcp.COD_CUENTA WHERE dcp.COD_CUENTA = :codCuenta");
		
					$consultarPagoParcial->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);

					/*===================================================================================
					SI SE OBTIENE LOS DATOS PROCEDEMOS A COMPARAR LOS DATOS
			 		====================================================================================*/

					if($consultarPagoParcial -> execute()){

						$pagoParcial = $consultarPagoParcial -> fetch(PDO::FETCH_ASSOC);
						$tipoVenta = $pagoParcial["TIPO_VENTA"];
						$fechaVenc = $pagoParcial["FECHA_VENC_PROXIMO"];
						$saldo = intval($pagoParcial["SALDO"]);

						$fecha = new DateTime($fechaVenc);
						$fechaDiff;

						// var_dump($pagoParcial["CUOTA_PAGADA"]);
						// var_dump($pagoParcial["CUOTA_PAGADA_DECIMAL"]);

						$cuotaRestar = intval($pagoParcialPre["CUOTA_PAGADA"]) - intval($pagoParcial["CUOTA_PAGADA"]);
						// var_dump($cuotaRestar);
						// return;


						/*============================================================
						PREGUNTAMOS EL TIPO DE VENTA PARA DISMINUIR LA FECHA
						==============================================================*/

						if($tipoVenta == "MENSUAL"){

							$fecha->sub(new DateInterval('P'.$cuotaRestar.'M'));
							$fechaDiff = date_format($fecha, "Y-m-d");

						}else if($tipoVenta == "QUINCENAL"){

							$fecha->sub(new DateInterval('P'.(intval($cuotaRestar)*2).'W'));
							$fechaDiff = date_format($fecha, "Y-m-d");

						}else if($tipoVenta == "SEMANAL"){

							$fecha->sub(new DateInterval('P'.$cuotaRestar.'W'));
							$fechaDiff = date_format($fecha, "Y-m-d");

						}else if($tipoVenta == "DIARIO"){

							$fecha->sub(new DateInterval('P'.$cuotaRestar.'D'));
							$fechaDiff = date_format($fecha, "Y-m-d");

						}


						// var_dump($fechaDiff);
						// return;


						$estadoCuenta = "CANCELADO";

						if($saldo > 0){

							$estadoCuenta = "CREDITO";

						}

						/*============================================================
							REALIZAMOS LA MODIFICACION
						==============================================================*/
						$modificar=$connection->prepare("UPDATE ctaspagar SET FECHA_VENC_PROXIMO = :fecha, ESTADO_CUENTA = :estadoCuenta WHERE COD_CUENTA = :codCuenta");

						$modificar->bindParam(":codCuenta", $datos["codCuenta"], PDO::PARAM_STR);
						$modificar->bindParam(":fecha", $fechaDiff, PDO::PARAM_STR);
						$modificar->bindParam(":estadoCuenta", $estadoCuenta, PDO::PARAM_STR);

						if($modificar -> execute()){

							$modificarEstado=$connection->prepare("UPDATE detctaspagar SET DET_MOVIMIENTO = 'ANULADO' WHERE TOKEN_DETCTASPAGAR = :tokenCuentaDet");

							$modificarEstado->bindParam(":tokenCuentaDet", $datos["tokenCuentaDet"], PDO::PARAM_STR);

							if ($modificarEstado -> execute()) {
								
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

				}else{

					return "error";

				}

			}else{

				return "error";

			}

		}

	}

	/*============================================================
		MOSTRAR COMPRAS
 	==============================================================*/

	static public function mdlMostrarCompras($item, $valor, $tabla, $order){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY $order ");
	           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
				
			return $stmt -> fetchAll();

		}else{

	 		$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");

	 		$stmt->execute();

	 		return $stmt-> fetchAll();
	 	}

	 	$stmt-> close();
		$stmt= null;

	}

	/*============================================================
		MODELO PERFIL PARA RESGISTRAR DATOS
 	==============================================================*/
 	static function mdlMostrarProductos($tabla, $item, $valor){
 		
 		if($valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
           			
			$stmt -> bindParam(":$item",  $valor, PDO::PARAM_STR);

			$stmt -> execute();
			
			return $stmt -> fetch();

		}else{

 			$stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
 			$stmt->execute();
 			return $stmt-> fetchAll();
 		}
 		
 	}

 	/*============================================================
		CREAR PAGOS
 	==============================================================*/
	static public function mdlModificarComentario($item1, $valor1, $item2, $valor2){

			// var_dump($valor1);
			// var_dump($valor2);

			$modificar=Conexion::conectar()->prepare("UPDATE ctaspagar SET OBSERVACIONES = :comentario WHERE COD_CUENTA = :codCuenta");
					
			$modificar->bindParam(":codCuenta", $valor1, PDO::PARAM_STR);
			$modificar->bindParam(":comentario", $valor2, PDO::PARAM_STR);

			if ($modificar-> execute()){

				return "ok";

			}else{

			   	return "error";
			   		
			}



	}


}